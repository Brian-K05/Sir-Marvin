<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Feedback::with(['submission.service', 'user', 'approver']);
        
        if ($filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($filter === 'approved') {
            $query->where('is_approved', true);
        }
        
        $feedbacks = $query->latest()->paginate(20);
        
        return view('admin.feedbacks.index', compact('feedbacks', 'filter'));
    }

    public function approve($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $feedback->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
        
        return redirect()->back()->with('success', 'Feedback approved successfully.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        
        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }
}
