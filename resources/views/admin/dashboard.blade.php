@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h2 class="admin-section-title">Overview</h2>

<!-- Stats Grid -->
<div class="admin-stats-grid">
        <div class="admin-stat-card admin-stat-card-primary">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">Total Submissions</p>
                    <p class="admin-stat-card-value">{{ $stats['total_submissions'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-stat-card admin-stat-card-warning">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">Pending Initial</p>
                    <p class="admin-stat-card-value">{{ $stats['pending_initial'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-stat-card admin-stat-card-info">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">In Progress</p>
                    <p class="admin-stat-card-value">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-stat-card admin-stat-card-success">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">Awaiting Final</p>
                    <p class="admin-stat-card-value">{{ $stats['awaiting_final'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-stat-card admin-stat-card-danger">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">Pending Payments</p>
                    <p class="admin-stat-card-value">{{ $stats['pending_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-stat-card admin-stat-card-purple">
            <div class="admin-stat-card-background"></div>
            <div class="admin-stat-card-content">
                <div class="admin-stat-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="admin-stat-card-info">
                    <p class="admin-stat-card-label">Total Services</p>
                    <p class="admin-stat-card-value">{{ $stats['total_services'] }}</p>
                </div>
            </div>
        </div>
    </div>

<!-- Recent Submissions Section -->
<div class="admin-section">
        <div class="admin-section-header">
            <h2 class="admin-section-title">Recent Submissions</h2>
            <a href="{{ route('admin.submissions.index') }}" class="admin-section-link">View All</a>
        </div>
        
        <!-- Filter Tabs -->
        <div class="admin-filter-tabs">
            <a href="{{ route('admin.dashboard', ['filter' => 'all']) }}" 
               class="admin-filter-tab {{ $filter === 'all' ? 'active' : '' }}">
                All Submissions
            </a>
            <a href="{{ route('admin.dashboard', ['filter' => 'completed']) }}" 
               class="admin-filter-tab {{ $filter === 'completed' ? 'active' : '' }}">
                Completed
            </a>
            <a href="{{ route('admin.dashboard', ['filter' => 'cancelled']) }}" 
               class="admin-filter-tab {{ $filter === 'cancelled' ? 'active' : '' }}">
                Cancelled
            </a>
        </div>
        
        <div class="admin-table-container">
            <table class="admin-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Initial Payment</th>
                        <th>Final Payment</th>
                        <th>Deadline</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_submissions as $submission)
                    <tr>
                        <td><span class="admin-table-id">#{{ $submission->id }}</span></td>
                        <td><span class="admin-table-text">{{ $submission->client_name }}</span></td>
                        <td><span class="admin-table-text">{{ $submission->client_email }}</span></td>
                        <td><span class="admin-table-text">{{ $submission->service->name }}</span></td>
                        <td>
                            <span class="admin-status-badge admin-status-{{ str_replace('_', '-', $submission->status) }}">
                                {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="admin-status-badge admin-status-{{ $submission->initial_payment_status }}">
                                {{ ucfirst($submission->initial_payment_status) }}
                            </span>
                        </td>
                        <td>
                            @if($submission->final_payment_status)
                                <span class="admin-status-badge admin-status-{{ $submission->final_payment_status }}">
                                    {{ ucfirst($submission->final_payment_status) }}
                                </span>
                            @else
                                <span class="admin-table-text">N/A</span>
                            @endif
                        </td>
                        <td><span class="admin-table-text">{{ $submission->deadline->format('M d, Y') }}</span></td>
                        <td><span class="admin-table-text">{{ $submission->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <a href="{{ route('admin.submissions.show', $submission->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="admin-table-empty">
                            <div class="admin-empty-state">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12H15M9 16H15M17 21H7C5.89543 21 5 20.1046 5 19V5C5 3.89543 5.89543 3 7 3H12.5858C12.851 3 13.1054 3.10536 13.2929 3.29289L18.7071 8.70711C18.8946 8.89464 19 9.149 19 9.41421V19C19 20.1046 18.1046 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p>No {{ $filter === 'all' ? '' : $filter }} submissions found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<!-- Pending Payments Section -->
<div class="admin-section">
        <div class="admin-section-header">
            <h2 class="admin-section-title">Pending Payments</h2>
            <a href="{{ route('admin.submissions.index') }}" class="admin-section-link">View All</a>
        </div>
        <div class="admin-table-container">
            <table class="admin-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Submission</th>
                        <th>Phase</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending_payments as $payment)
                    <tr>
                        <td><span class="admin-table-id">#{{ $payment->id }}</span></td>
                        <td><span class="admin-table-text">#{{ $payment->submission->id }} - {{ $payment->submission->client_name }}</span></td>
                        <td><span class="admin-table-text">{{ ucfirst($payment->phase) }}</span></td>
                        <td><span class="admin-table-amount">₱{{ number_format($payment->amount, 2) }}</span></td>
                        <td><span class="admin-table-text">{{ $payment->reference_number }}</span></td>
                        <td>
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="admin-table-empty">
                            <div class="admin-empty-state">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p>No pending payments</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

