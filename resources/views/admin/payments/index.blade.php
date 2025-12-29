@extends('admin.layout')

@section('title', 'Payments')

@section('content')
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Payment Management</h2>
        <div class="admin-section-actions">
            <span class="admin-count-badge">{{ $payments->total() }} Total</span>
        </div>
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
                    <th>Status</th>
                    <th>Verified At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td><span class="admin-table-id">#{{ $payment->id }}</span></td>
                    <td>
                        <div class="admin-table-client">
                            <span class="admin-table-text">#{{ $payment->submission_id }}</span>
                            <small class="admin-table-email">{{ $payment->submission->client_name }}</small>
                        </div>
                    </td>
                    <td>
                        <span class="admin-status-badge {{ $payment->phase === 'initial' ? 'admin-status-warning' : 'admin-status-success' }}" style="font-size: 0.75rem;">
                            {{ ucfirst($payment->phase) }}
                        </span>
                    </td>
                    <td><span class="admin-table-amount">₱{{ number_format($payment->amount, 2) }}</span></td>
                    <td><span class="admin-table-text" style="font-family: monospace; font-size: 0.875rem;">{{ $payment->reference_number }}</span></td>
                    <td>
                        <span class="admin-status-badge admin-status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>
                        @if($payment->verified_at)
                            <span class="admin-table-text">{{ $payment->verified_at->format('M d, Y') }}</span>
                            <small class="admin-table-email">{{ $payment->verified_at->format('g:i A') }}</small>
                        @else
                            <span class="admin-table-text" style="color: #94A3B8;">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="admin-table-empty">
                        <div class="admin-empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>No payments found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($payments->hasPages())
    <div class="admin-pagination">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection

