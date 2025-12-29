<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Submission;
use App\Models\Payment;
use App\Models\Admin;
use App\Notifications\Admin\NewSubmissionNotification;
use App\Notifications\Admin\PaymentProofUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class SubmissionController extends Controller
{
    public function index()
    {
        // Get all submissions for the authenticated user
        $user = auth()->user();
        $submissions = Submission::where('client_email', $user->email)
            ->with(['service', 'payments'])
            ->latest()
            ->paginate(10);
        
        return view('public.submission.index', compact('submissions'));
    }

    public function create(Request $request)
    {
        // User is authenticated (middleware ensures this)
        $serviceId = $request->query('service');
        $service = $serviceId ? Service::findOrFail($serviceId) : null;
        $services = Service::where('is_active', true)->get();
        
        return view('public.submission.create', compact('services', 'service'));
    }

    public function store(Request $request)
    {
        // User is authenticated (middleware ensures this)
        $user = $request->user();
        
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:51200',
            'instructions' => 'nullable|string|max:2000',
            'deadline' => 'required|date|after:today',
            'initial_payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'initial_payment_reference' => 'required|string|max:255',
        ]);

        // Security: Validate file uploads
        $documentFile = $request->file('document');
        $documentValidation = validate_file_upload($documentFile, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'], 51200);
        if (!$documentValidation['valid']) {
            return back()->withErrors(['document' => $documentValidation['error']])->withInput();
        }

        $proofFile = $request->file('initial_payment_proof');
        $proofValidation = validate_file_upload($proofFile, ['application/pdf', 'image/jpeg', 'image/png'], 5120);
        if (!$proofValidation['valid']) {
            return back()->withErrors(['initial_payment_proof' => $proofValidation['error']])->withInput();
        }

        // Security: Sanitize filename and generate secure storage path
        $documentName = sanitize_filename($documentFile->getClientOriginalName());
        $documentPath = $documentFile->storeAs('documents', time() . '_' . $documentName, 'public');
        
        $proofName = sanitize_filename($proofFile->getClientOriginalName());
        $proofPath = $proofFile->storeAs('proofs', time() . '_' . $proofName, 'public');

        // Get service to calculate payment amount
        $service = Service::findOrFail($validated['service_id']);
        $initialAmount = $service->initial_payment_amount;

        // Security: Sanitize user input
        $sanitizedInstructions = isset($validated['instructions']) ? sanitize_input($validated['instructions']) : null;
        $sanitizedReference = sanitize_input($validated['initial_payment_reference']);

        // Create submission using authenticated user's information
        $submission = Submission::create([
            'service_id' => $validated['service_id'],
            'client_name' => $user->name,
            'client_email' => $user->email,
            'document_path' => $documentPath,
            'instructions' => $sanitizedInstructions,
            'deadline' => $validated['deadline'],
            'status' => 'pending_initial',
            'initial_payment_status' => 'pending',
            'final_payment_status' => 'pending',
        ]);

        // Create initial payment
        $payment = Payment::create([
            'submission_id' => $submission->id,
            'phase' => 'initial',
            'proof_path' => $proofPath,
            'reference_number' => $sanitizedReference,
            'amount' => $initialAmount,
            'status' => 'pending',
        ]);

        // Notify admin of new submission
        try {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new NewSubmissionNotification($submission));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send new submission notification: ' . $e->getMessage());
        }

        return redirect()->route('submissions.show', $submission->id)
            ->with('success', 'Your submission has been received. We will verify your payment and get back to you soon.');
    }

    public function show($id)
    {
        $submission = Submission::with(['service', 'payments', 'feedback'])->findOrFail($id);
        
        // Ensure the submission belongs to the authenticated user
        if ($submission->client_email !== auth()->user()->email) {
            abort(403, 'You do not have permission to view this submission.');
        }
        
        return view('public.submission.show', compact('submission'));
    }

    public function uploadFinalPayment(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        // Ensure the submission belongs to the authenticated user
        if ($submission->client_email !== auth()->user()->email) {
            abort(403, 'You do not have permission to upload payment for this submission.');
        }
        
        if ($submission->status !== 'awaiting_final') {
            return redirect()->back()->with('error', 'Final payment is not yet required for this submission.');
        }

        $validated = $request->validate([
            'final_payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'final_payment_reference' => 'required|string|max:255',
        ]);

        // Security: Validate file upload
        $proofFile = $request->file('final_payment_proof');
        $proofValidation = validate_file_upload($proofFile, ['application/pdf', 'image/jpeg', 'image/png'], 5120);
        if (!$proofValidation['valid']) {
            return back()->withErrors(['final_payment_proof' => $proofValidation['error']])->withInput();
        }

        // Security: Sanitize filename and generate secure storage path
        $proofName = sanitize_filename($proofFile->getClientOriginalName());
        $proofPath = $proofFile->storeAs('proofs', time() . '_' . $proofName, 'public');

        // Security: Sanitize user input
        $sanitizedFinalReference = sanitize_input($validated['final_payment_reference']);

        $service = $submission->service;
        $finalAmount = $service->price - $service->initial_payment_amount;

        $payment = Payment::create([
            'submission_id' => $submission->id,
            'phase' => 'final',
            'proof_path' => $proofPath,
            'reference_number' => $sanitizedFinalReference,
            'amount' => $finalAmount,
            'status' => 'pending',
        ]);

        // Notify admin of final payment proof upload
        try {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new PaymentProofUploadedNotification($payment));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send payment proof notification: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Final payment proof uploaded successfully. We will verify and notify you once approved.');
    }

    public function downloadCorrected($id)
    {
        $submission = Submission::findOrFail($id);
        
        // Ensure the submission belongs to the authenticated user
        if ($submission->client_email !== auth()->user()->email) {
            abort(403, 'You do not have permission to download this file.');
        }
        
        if ($submission->status !== 'completed' || !$submission->corrected_file_path) {
            abort(404, 'Corrected file not available.');
        }

        if ($submission->final_payment_status !== 'approved') {
            return redirect()->back()->with('error', 'Final payment must be approved before downloading the corrected file.');
        }

        return Storage::disk('public')->download($submission->corrected_file_path);
    }
}
