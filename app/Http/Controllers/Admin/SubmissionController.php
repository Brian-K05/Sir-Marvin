<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['service', 'payments'])
            ->latest()
            ->paginate(20);
        
        return view('admin.submissions.index', compact('submissions'));
    }

    public function show($id)
    {
        $submission = Submission::with(['service', 'payments'])->findOrFail($id);
        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending_initial,initial_approved,in_progress,awaiting_final,final_approved,completed,cancelled',
        ]);

        $submission->update(['status' => $validated['status']]);

        // Update payment statuses based on submission status
        if ($validated['status'] === 'initial_approved') {
            $submission->update(['initial_payment_status' => 'approved']);
            $initialPayment = $submission->payments()->where('phase', 'initial')->first();
            if ($initialPayment) {
                $initialPayment->update([
                    'status' => 'approved',
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                ]);
            }
            
            // Notify client of initial payment approval
            try {
                $lines = [
                    'Great news! Your initial payment has been verified and approved.',
                    '**Service:** ' . $submission->service->name,
                    '**Deadline:** ' . $submission->deadline->format('F d, Y'),
                    'We have now begun working on your document. You will be notified once the work is completed and ready for your review.',
                    'Thank you for choosing our services!'
                ];
                
                Mail::to($submission->client_email)->send(new \App\Mail\ClientNotificationMail(
                    'Initial Payment Approved - Work in Progress',
                    'Hello ' . $submission->client_name . ',',
                    $lines,
                    route('submissions.show', $submission->id),
                    'View Submission Status'
                ));
            } catch (\Exception $e) {
                \Log::error('Failed to send initial payment approved notification: ' . $e->getMessage());
            }
        }

        if ($validated['status'] === 'final_approved') {
            $submission->update(['final_payment_status' => 'approved']);
            $finalPayment = $submission->payments()->where('phase', 'final')->first();
            if ($finalPayment) {
                $finalPayment->update([
                    'status' => 'approved',
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                ]);
            }
            
            // Notify client of final payment approval
            try {
                $lines = [
                    'Your final payment has been verified and approved!',
                    '**Service:** ' . $submission->service->name,
                    'Your corrected document is now ready for download.',
                    'Thank you for your business! We hope you are satisfied with our service.',
                    'If you have any questions or need further assistance, please don\'t hesitate to contact us.'
                ];
                
                Mail::to($submission->client_email)->send(new \App\Mail\ClientNotificationMail(
                    'Final Payment Approved - Document Ready for Download',
                    'Hello ' . $submission->client_name . ',',
                    $lines,
                    route('submissions.download', $submission->id),
                    'Download Corrected Document'
                ));
            } catch (\Exception $e) {
                \Log::error('Failed to send final payment approved notification: ' . $e->getMessage());
            }
        }
        
        if ($validated['status'] === 'in_progress') {
            // Update status to in_progress when work begins
            $submission->refresh();
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function uploadCorrected(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        $validated = $request->validate([
            'corrected_file' => 'required|file|mimes:pdf,doc,docx|max:51200',
        ]);

        // Security: Validate file upload
        $correctedFile = $request->file('corrected_file');
        $fileValidation = validate_file_upload($correctedFile, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'], 51200);
        if (!$fileValidation['valid']) {
            return back()->withErrors(['corrected_file' => $fileValidation['error']])->withInput();
        }

        // Security: Sanitize filename and generate secure storage path
        $fileName = sanitize_filename($correctedFile->getClientOriginalName());
        $filePath = $correctedFile->storeAs('corrected', time() . '_' . $fileName, 'public');
        
        $submission->update([
            'corrected_file_path' => $filePath,
            'status' => 'awaiting_final',
        ]);

        // Notify client that work is completed
        try {
            $finalAmount = $submission->service->price - $submission->service->initial_payment_amount;
            $lines = [
                'Great news! We have completed the work on your document.',
                '**Service:** ' . $submission->service->name,
                'Your corrected document is ready. To download it, please complete the final payment.',
                '**Final Payment Amount:** ₱' . number_format($finalAmount, 2),
                'Once your final payment is verified and approved, you will be able to download your corrected document.',
                'Thank you for your patience!'
            ];
            
            Mail::to($submission->client_email)->send(new \App\Mail\ClientNotificationMail(
                'Work Completed - Final Payment Required',
                'Hello ' . $submission->client_name . ',',
                $lines,
                route('submissions.show', $submission->id),
                'Upload Final Payment'
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send work completed notification: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Corrected file uploaded successfully. Submission status changed to "Awaiting Final Payment".');
    }
}
