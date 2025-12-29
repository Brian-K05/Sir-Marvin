<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_submissions' => Submission::count(),
            'pending_initial' => Submission::where('status', 'pending_initial')->count(),
            'in_progress' => Submission::where('status', 'in_progress')->count(),
            'awaiting_final' => Submission::where('status', 'awaiting_final')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_services' => Service::count(),
        ];

        // Get filter from request (all, completed, cancelled)
        $filter = $request->get('filter', 'all');
        
        // Build query for recent submissions based on filter
        $submissionsQuery = Submission::with(['service', 'payments', 'initialPayment', 'finalPayment']);
        
        if ($filter === 'completed') {
            $submissionsQuery->where('status', 'completed');
        } elseif ($filter === 'cancelled') {
            $submissionsQuery->where('status', 'cancelled');
        }
        // If filter is 'all', show all submissions
        
        $recent_submissions = $submissionsQuery
            ->latest()
            ->take(20)
            ->get();

        $pending_payments = Payment::with(['submission.service'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_submissions', 'pending_payments', 'filter'));
    }
}
