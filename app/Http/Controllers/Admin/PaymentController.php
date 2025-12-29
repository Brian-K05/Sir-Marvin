<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['submission.service'])
            ->latest()
            ->paginate(20);
        
        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['submission.service', 'verifier'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve($id)
    {
        $payment = Payment::with('submission')->findOrFail($id);
        
        $payment->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => auth('admin')->id(),
        ]);

        // Update submission payment status
        if ($payment->phase === 'initial') {
            $payment->submission->update([
                'initial_payment_status' => 'approved',
                'status' => 'initial_approved',
            ]);
            
            // Notify client of initial payment approval
            try {
                $submission = $payment->submission;
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
        } elseif ($payment->phase === 'final') {
            $payment->submission->update([
                'final_payment_status' => 'approved',
                'status' => 'final_approved',
            ]);
            
            // Notify client of final payment approval
            try {
                $submission = $payment->submission;
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

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $payment = Payment::with('submission')->findOrFail($id);
        
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $payment->update([
            'status' => 'rejected',
            'admin_notes' => isset($validated['admin_notes']) ? sanitize_input($validated['admin_notes']) : null,
            'verified_at' => now(),
            'verified_by' => auth('admin')->id(),
        ]);

        // Update submission payment status
        if ($payment->phase === 'initial') {
            $payment->submission->update([
                'initial_payment_status' => 'rejected',
            ]);
        } elseif ($payment->phase === 'final') {
            $payment->submission->update([
                'final_payment_status' => 'rejected',
            ]);
        }

        return redirect()->back()->with('success', 'Payment rejected.');
    }
}
