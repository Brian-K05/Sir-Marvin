<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create($submissionId)
    {
        $submission = Submission::with(['service', 'feedback'])->findOrFail($submissionId);
        $user = auth()->user();
        
        // Ensure the submission belongs to the authenticated user
        if ($submission->client_email !== $user->email) {
            abort(403, 'You do not have permission to leave feedback for this submission.');
        }
        
        // Check if submission is completed
        if ($submission->status !== 'completed') {
            return redirect()->route('submissions.show', $submissionId)
                ->with('error', 'You can only leave feedback for completed submissions.');
        }
        
        // Check if feedback already exists
        if ($submission->feedback) {
            return redirect()->route('submissions.show', $submissionId)
                ->with('info', 'You have already left feedback for this submission.');
        }
        
        return view('public.feedback.create', compact('submission'));
    }

    public function store(Request $request, $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        $user = auth()->user();
        
        // Ensure the submission belongs to the authenticated user
        if ($submission->client_email !== $user->email) {
            abort(403, 'You do not have permission to leave feedback for this submission.');
        }
        
        // Check if submission is completed
        if ($submission->status !== 'completed') {
            return redirect()->route('submissions.show', $submissionId)
                ->with('error', 'You can only leave feedback for completed submissions.');
        }
        
        // Check if feedback already exists
        if ($submission->feedback) {
            return redirect()->route('submissions.show', $submissionId)
                ->with('info', 'You have already left feedback for this submission.');
        }
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Security: Sanitize user input
        $sanitizedComment = isset($validated['comment']) ? sanitize_input($validated['comment']) : null;
        
        Feedback::create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'rating' => $validated['rating'],
            'comment' => $sanitizedComment,
            'is_approved' => false,
        ]);
        
        return redirect()->route('feedbacks.success')
            ->with('success', 'Thank you for your feedback! It is pending admin approval and will be displayed once approved.');
    }
}
