@extends('admin.layout')

@section('title', 'Submissions')

@section('content')
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">All Submissions</h2>
        <div class="admin-section-actions">
            <span class="admin-count-badge">{{ $submissions->total() }} Total</span>
        </div>
    </div>
    
    <div class="admin-table-container">
        <table class="admin-table-modern">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Payments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr>
                    <td><span class="admin-table-id">#{{ $submission->id }}</span></td>
                    <td>
                        <div class="admin-table-client">
                            <span class="admin-table-text">{{ $submission->client_name }}</span>
                            <small class="admin-table-email">{{ $submission->client_email }}</small>
                        </div>
                    </td>
                    <td><span class="admin-table-text">{{ $submission->service->name }}</span></td>
                    <td>
                        <span class="admin-status-badge admin-status-{{ str_replace('_', '-', $submission->status) }}">
                            {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                        </span>
                    </td>
                    <td><span class="admin-table-text">{{ $submission->deadline->format('M d, Y') }}</span></td>
                    <td>
                        <div class="admin-payment-status">
                            <span class="admin-status-badge admin-status-{{ $submission->initial_payment_status }}" style="font-size: 0.7rem; padding: 0.25rem 0.5rem; margin-right: 0.5rem;">
                                Initial: {{ ucfirst($submission->initial_payment_status) }}
                            </span>
                            <span class="admin-status-badge admin-status-{{ $submission->final_payment_status }}" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                Final: {{ ucfirst($submission->final_payment_status) }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.submissions.show', $submission->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">
                            View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="admin-table-empty">
                        <div class="admin-empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12H15M9 16H15M17 21H7C5.89543 21 5 20.1046 5 19V5C5 3.89543 5.89543 3 7 3H12.5858C12.851 3 13.1054 3.10536 13.2929 3.29289L18.7071 8.70711C18.8946 8.89464 19 9.149 19 9.41421V19C19 20.1046 18.1046 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>No submissions found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($submissions->hasPages())
    <div class="admin-pagination">
        {{ $submissions->links() }}
    </div>
    @endif
</div>
@endsection

