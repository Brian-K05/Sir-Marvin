@extends('admin.layout')

@section('title', 'Feedbacks')

@section('content')
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Client Feedbacks</h2>
        <div class="admin-section-actions">
            <span class="admin-count-badge">{{ $feedbacks->total() }} Total</span>
        </div>
    </div>
    
    <div class="admin-filter-tabs">
        <a href="{{ route('admin.feedbacks.index', ['filter' => 'all']) }}" class="admin-filter-tab {{ $filter === 'all' ? 'active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.feedbacks.index', ['filter' => 'pending']) }}" class="admin-filter-tab {{ $filter === 'pending' ? 'active' : '' }}">
            Pending Approval
        </a>
        <a href="{{ route('admin.feedbacks.index', ['filter' => 'approved']) }}" class="admin-filter-tab {{ $filter === 'approved' ? 'active' : '' }}">
            Approved
        </a>
    </div>
    
    <div class="admin-table-container">
        <table class="admin-table-modern">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                <tr>
                    <td><span class="admin-table-id">#{{ $feedback->id }}</span></td>
                    <td>
                        <div class="admin-table-client">
                            <span class="admin-table-text">{{ $feedback->user->name }}</span>
                            <small class="admin-table-email">{{ $feedback->user->email }}</small>
                        </div>
                    </td>
                    <td><span class="admin-table-text">{{ $feedback->submission->service->name }}</span></td>
                    <td>
                        <div class="admin-rating-display">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="18" height="18" viewBox="0 0 20 20" fill="{{ $i <= $feedback->rating ? '#FBBF24' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 15L4.175 18.5L5.35 11.975L0.7 7.5L7.325 6.875L10 1L12.675 6.875L19.3 7.5L14.65 11.975L15.825 18.5L10 15Z"/>
                                </svg>
                            @endfor
                        </div>
                    </td>
                    <td>
                        @if($feedback->comment)
                            <div class="admin-comment-preview">{{ Str::limit($feedback->comment, 60) }}</div>
                            @if(strlen($feedback->comment) > 60)
                                <button type="button" class="admin-btn-link" onclick="alert('{{ addslashes($feedback->comment) }}')" style="margin-top: 0.25rem;">View Full</button>
                            @endif
                        @else
                            <span style="color: #94A3B8; font-style: italic;">No comment</span>
                        @endif
                    </td>
                    <td>
                        @if($feedback->is_approved)
                            <span class="admin-status-badge admin-status-completed">Approved</span>
                            @if($feedback->approver)
                                <br><small style="color: #64748B; font-size: 0.75rem; margin-top: 0.25rem; display: block;">By: {{ $feedback->approver->name }}</small>
                            @endif
                        @else
                            <span class="admin-status-badge admin-status-pending">Pending</span>
                        @endif
                    </td>
                    <td><span class="admin-table-text">{{ $feedback->created_at->format('M d, Y') }}</span></td>
                    <td>
                        <div class="admin-action-buttons">
                            @if(!$feedback->is_approved)
                                <form action="{{ route('admin.feedbacks.approve', $feedback->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="admin-btn admin-btn-sm admin-btn-primary" onclick="return confirm('Approve this feedback?')">Approve</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="admin-table-empty">
                        <div class="admin-empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2L12.09 7.26L18 8.27L14 12.14L14.91 18.02L10 15.77L5.09 18.02L6 12.14L2 8.27L7.91 7.26L10 2Z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            <p>No feedbacks found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($feedbacks->hasPages())
    <div class="admin-pagination">
        {{ $feedbacks->links() }}
    </div>
    @endif
</div>
@endsection

