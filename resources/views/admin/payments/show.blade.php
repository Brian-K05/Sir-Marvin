@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Payment Details')

@section('content')
<div class="admin-detail-page">
    <div class="admin-detail-header">
        <div>
            <h2 class="admin-detail-title">Payment #{{ $payment->id }}</h2>
            <p class="admin-detail-subtitle">{{ ucfirst($payment->phase) }} Payment • {{ $payment->submission->client_name }}</p>
        </div>
        <span class="admin-status-badge admin-status-{{ $payment->status }}" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
            {{ ucfirst($payment->status) }}
        </span>
    </div>

    <div class="admin-detail-grid">
        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Payment Information</h3>
            <div class="admin-detail-info">
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Phase</span>
                    <span class="admin-detail-value">{{ ucfirst($payment->phase) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Amount</span>
                    <span class="admin-detail-value" style="color: #059669; font-weight: 700; font-size: 1.25rem;">₱{{ number_format($payment->amount, 2) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Reference Number</span>
                    <span class="admin-detail-value" style="font-family: monospace; font-size: 1rem;">{{ $payment->reference_number }}</span>
                </div>
                @if($payment->verified_at)
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Verified At</span>
                    <span class="admin-detail-value">{{ $payment->verified_at->format('F d, Y g:i A') }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Verified By</span>
                    <span class="admin-detail-value">{{ $payment->verifier->name ?? 'N/A' }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Submission Information</h3>
            <div class="admin-detail-info">
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Submission ID</span>
                    <span class="admin-detail-value">#{{ $payment->submission_id }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Client</span>
                    <span class="admin-detail-value">{{ $payment->submission->client_name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Service</span>
                    <span class="admin-detail-value">{{ $payment->submission->service->name }}</span>
                </div>
                <div class="admin-detail-item">
                    <a href="{{ route('admin.submissions.show', $payment->submission_id) }}" class="admin-btn admin-btn-primary" style="margin-top: 1rem;">View Submission</a>
                </div>
            </div>
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Payment Proof</h3>
            <div class="admin-file-download">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                    <path d="M4 4H16V16H4V4ZM2 4C2 2.89543 2.89543 2 4 2H16C17.1046 2 18 2.89543 18 4V16C18 17.1046 17.1046 18 16 18H4C2.89543 18 2 17.1046 2 16V4Z" fill="currentColor"/>
                </svg>
                <a href="{{ Storage::url($payment->proof_path) }}" target="_blank" class="admin-btn admin-btn-primary">View Payment Proof</a>
            </div>
        </div>

        @if($payment->status === 'pending')
        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Payment Actions</h3>
            <div class="admin-payment-actions">
                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="admin-form">
                    @csrf
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-block" onclick="return confirm('Approve this payment?')">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                            <path d="M7 10L9 12L13 8M19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Approve Payment
                    </button>
                </form>
                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="admin-form" style="margin-top: 1rem;">
                    @csrf
                    <div class="admin-form-group">
                        <label for="admin_notes" class="admin-form-label">Rejection Notes (optional)</label>
                        <textarea name="admin_notes" id="admin_notes" class="admin-form-textarea" rows="3" placeholder="Enter reason for rejection..."></textarea>
                    </div>
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-block" onclick="return confirm('Reject this payment?')">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                            <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M7 7L13 13M13 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Reject Payment
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($payment->admin_notes)
        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Admin Notes</h3>
            <div class="admin-notes-box">
                <p>{{ $payment->admin_notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

