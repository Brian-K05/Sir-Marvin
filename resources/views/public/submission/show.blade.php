@extends('layouts.public')

@section('title', 'Submission Details')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Submission Details</h1>
    </div>
</section>

<section class="submission-details">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="submission-info">
            <h2>Service: {{ $submission->service->name }}</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Status:</strong>
                    <span class="status-badge status-{{ str_replace('_', '-', $submission->status) }}">
                        {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                    </span>
                </div>
                <div class="info-item">
                    <strong>Client Name:</strong> {{ $submission->client_name }}
                </div>
                <div class="info-item">
                    <strong>Client Email:</strong> {{ $submission->client_email }}
                </div>
                <div class="info-item">
                    <strong>Deadline:</strong> {{ $submission->deadline->format('F d, Y') }}
                </div>
                <div class="info-item">
                    <strong>Submitted:</strong> {{ $submission->created_at->format('F d, Y g:i A') }}
                </div>
            </div>
        </div>

        @if($submission->instructions)
        <div class="submission-info" style="margin-bottom: 2rem;">
            <h2>Your Instructions</h2>
            <div style="background: var(--off-white); padding: 1.5rem; border-radius: var(--radius-md); border-left: 4px solid var(--primary-blue);">
                <p style="white-space: pre-wrap; color: var(--charcoal); line-height: 1.6; margin: 0;">{{ $submission->instructions }}</p>
            </div>
        </div>
        @endif

        <div class="payment-section">
            <h3>Payment Status</h3>
            
            <div class="payment-item">
                <h4>Initial Payment (50%)</h4>
                <p>Status: 
                    <span class="status-badge status-{{ $submission->initial_payment_status }}">
                        {{ ucfirst($submission->initial_payment_status) }}
                    </span>
                </p>
                @php
                    $initialPayment = $submission->payments->where('phase', 'initial')->first();
                @endphp
                @if($initialPayment)
                    <p>Reference: {{ $initialPayment->reference_number }}</p>
                    <p>Amount: ₱{{ number_format($initialPayment->amount, 2) }}</p>
                @endif
            </div>

            @if($submission->status === 'awaiting_final' || $submission->status === 'final_approved' || $submission->status === 'completed')
            <div class="payment-item">
                <h4>Final Payment (50%)</h4>
                <p>Status: 
                    <span class="status-badge status-{{ $submission->final_payment_status }}">
                        {{ ucfirst($submission->final_payment_status) }}
                    </span>
                </p>
                @php
                    $finalPayment = $submission->payments->where('phase', 'final')->first();
                @endphp
                @if($finalPayment)
                    <p>Reference: {{ $finalPayment->reference_number }}</p>
                    <p>Amount: ₱{{ number_format($finalPayment->amount, 2) }}</p>
                @elseif($submission->status === 'awaiting_final')
                    <div class="gcash-info-box" style="background: var(--light-gray); border: 2px solid var(--professional-blue); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 1.5rem;">
                        <h4 style="margin-top: 0; color: var(--deep-navy); font-size: 1.1rem;">GCash Account Details</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div>
                                <strong style="color: var(--deep-navy);">GCash Number:</strong>
                                <span style="font-size: 1.2rem; font-weight: bold; color: var(--professional-blue); margin-left: 0.5rem;">09223549524</span>
                            </div>
                            <div>
                                <strong style="color: var(--deep-navy);">Account Name:</strong>
                                <span style="font-size: 1.1rem; font-weight: 600; color: var(--deep-navy); margin-left: 0.5rem;">Marvin Dominic B.</span>
                            </div>
                        </div>
                        <p style="margin-top: 1rem; margin-bottom: 0; font-size: 0.9rem; color: var(--warm-gray);">
                            <strong>Note:</strong> Please send the final payment to the GCash number above.
                        </p>
                    </div>
                    <form action="{{ route('submissions.upload-final', $submission->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="final_payment_proof">Upload Final Payment Proof *</label>
                            <input type="file" name="final_payment_proof" id="final_payment_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('final_payment_proof')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="final_payment_reference">GCash Reference Number *</label>
                            <input type="text" name="final_payment_reference" id="final_payment_reference" required>
                            @error('final_payment_reference')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn-primary">Upload Final Payment</button>
                    </form>
                @endif
            </div>
            @endif
        </div>

        @if($submission->status === 'completed' && $submission->corrected_file_path && $submission->final_payment_status === 'approved')
        <div class="download-section">
            <h3>Corrected Document</h3>
            <p>Your corrected document is ready for download.</p>
            <a href="{{ route('submissions.download', $submission->id) }}" class="btn-primary">Download Corrected File</a>
        </div>
        @endif

        @if($submission->status === 'completed')
        <div class="feedback-section">
            <h3>Share Your Experience</h3>
            @if($submission->feedback)
                @if($submission->feedback->is_approved)
                    <div class="feedback-display">
                        <p>Thank you for your feedback!</p>
                        <div class="rating-display">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="{{ $i <= $submission->feedback->rating ? '#FBBF24' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 15L4.175 18.5L5.35 11.975L0.7 7.5L7.325 6.875L10 1L12.675 6.875L19.3 7.5L14.65 11.975L15.825 18.5L10 15Z"/>
                                </svg>
                            @endfor
                        </div>
                        @if($submission->feedback->comment)
                            <p class="feedback-comment">{{ $submission->feedback->comment }}</p>
                        @endif
                    </div>
                @else
                    <p>Your feedback is pending admin approval. Thank you for sharing your experience!</p>
                @endif
            @else
                <p>We'd love to hear about your experience with our service. Please leave a review!</p>
                <a href="{{ route('feedbacks.create', $submission->id) }}" class="btn-primary">Leave Feedback</a>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection

