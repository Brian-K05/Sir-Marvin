@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Submission Details')

@section('content')
<div class="admin-detail-page">
    <div class="admin-detail-header">
        <div>
            <h2 class="admin-detail-title">Submission #{{ $submission->id }}</h2>
            <p class="admin-detail-subtitle">{{ $submission->client_name }} • {{ $submission->service->name }}</p>
        </div>
        <span class="admin-status-badge admin-status-{{ str_replace('_', '-', $submission->status) }}" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
            {{ ucwords(str_replace('_', ' ', $submission->status)) }}
        </span>
    </div>

    <div class="admin-detail-grid">
        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Client Information</h3>
            <div class="admin-detail-info">
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Name</span>
                    <span class="admin-detail-value">{{ $submission->client_name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Email</span>
                    <span class="admin-detail-value">{{ $submission->client_email }}</span>
                </div>
            </div>
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Service Details</h3>
            <div class="admin-detail-info">
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Service</span>
                    <span class="admin-detail-value">{{ $submission->service->name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Price</span>
                    <span class="admin-detail-value" style="color: #059669; font-weight: 700;">₱{{ number_format($submission->service->price, 2) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-label">Deadline</span>
                    <span class="admin-detail-value">{{ $submission->deadline->format('F d, Y') }}</span>
                </div>
            </div>
        </div>

        @if($submission->instructions)
        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Client Instructions</h3>
            <div class="admin-detail-info">
                <div class="admin-detail-item" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
                    <span class="admin-detail-label">Instructions</span>
                    <div style="background: #F1F5F9; padding: 1rem; border-radius: 8px; width: 100%; white-space: pre-wrap; color: #1E293B; line-height: 1.6;">{{ $submission->instructions }}</div>
                </div>
            </div>
        </div>
        @endif

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Update Status</h3>
            <form action="{{ route('admin.submissions.update-status', $submission->id) }}" method="POST" class="admin-form-inline">
                @csrf
                <select name="status" class="admin-form-select">
                    <option value="pending_initial" {{ $submission->status === 'pending_initial' ? 'selected' : '' }}>Pending Initial</option>
                    <option value="initial_approved" {{ $submission->status === 'initial_approved' ? 'selected' : '' }}>Initial Approved</option>
                    <option value="in_progress" {{ $submission->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="awaiting_final" {{ $submission->status === 'awaiting_final' ? 'selected' : '' }}>Awaiting Final</option>
                    <option value="final_approved" {{ $submission->status === 'final_approved' ? 'selected' : '' }}>Final Approved</option>
                    <option value="completed" {{ $submission->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $submission->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="admin-btn admin-btn-primary">Update Status</button>
            </form>
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Payments</h3>
            <div class="admin-payments-list">
                @forelse($submission->payments as $payment)
                <div class="admin-payment-item">
                    <div class="admin-payment-header">
                        <div>
                            <span class="admin-payment-phase">{{ ucfirst($payment->phase) }} Payment</span>
                            <span class="admin-payment-amount">₱{{ number_format($payment->amount, 2) }}</span>
                        </div>
                        <span class="admin-status-badge admin-status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="admin-payment-details">
                        <span class="admin-payment-ref">Ref: {{ $payment->reference_number }}</span>
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">View Details</a>
                    </div>
                </div>
                @empty
                <p style="color: #94A3B8; text-align: center; padding: 2rem;">No payments yet</p>
                @endforelse
            </div>
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Upload Corrected File</h3>
            @if($submission->status === 'in_progress' || $submission->status === 'initial_approved')
            <form action="{{ route('admin.submissions.upload-corrected', $submission->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                <div class="admin-form-group">
                    <label for="corrected_file" class="admin-form-label">Select File</label>
                    <input type="file" name="corrected_file" id="corrected_file" accept=".pdf,.doc,.docx" required class="admin-form-input">
                </div>
                <button type="submit" class="admin-btn admin-btn-primary">Upload Corrected File</button>
            </form>
            @elseif($submission->corrected_file_path)
            <div class="admin-file-download">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                    <path d="M10 2V12M10 12L7 9M10 12L13 9M4 14V16C4 17.1046 4.89543 18 6 18H14C15.1046 18 16 17.1046 16 16V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <a href="{{ Storage::url($submission->corrected_file_path) }}" target="_blank" class="admin-btn admin-btn-primary">Download Corrected File</a>
            </div>
            @else
            <p style="color: #94A3B8; text-align: center; padding: 1rem;">Corrected file not yet uploaded.</p>
            @endif
        </div>

        <div class="admin-detail-card">
            <h3 class="admin-detail-card-title">Original Document</h3>
            <div class="admin-file-download">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                    <path d="M10 2V12M10 12L7 9M10 12L13 9M4 14V16C4 17.1046 4.89543 18 6 18H14C15.1046 18 16 17.1046 16 16V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <a href="{{ Storage::url($submission->document_path) }}" target="_blank" class="admin-btn admin-btn-primary">Download Original Document</a>
            </div>
        </div>
    </div>
</div>
@endsection

