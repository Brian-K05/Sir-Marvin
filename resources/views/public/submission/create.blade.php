@extends('layouts.public')

@section('title', 'Book a Service')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Book a Service</h1>
        <p class="page-subtitle">Submit your document for professional editing</p>
    </div>
</section>

<section class="submission-form-section">
    <div class="container">
        <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="submission-form" id="submissionForm">
            @csrf

            <div class="form-group">
                <label for="service_id" class="form-label">Select Service *</label>
                <select name="service_id" id="service_id" class="form-select" required>
                    <option value="">Choose a service...</option>
                    @foreach($services as $svc)
                        <option value="{{ $svc->id }}" 
                            data-price="{{ $svc->price }}"
                            data-initial="{{ $svc->initial_payment_amount }}"
                            data-final="{{ $svc->price - $svc->initial_payment_amount }}"
                            {{ ($service && $service->id == $svc->id) ? 'selected' : '' }}>
                            {{ $svc->name }} - ₱{{ number_format($svc->price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="service-info" id="serviceInfo" style="display: none;">
                <div class="info-box">
                    <h3>Payment Information</h3>
                    <p>Initial Payment (50%): <strong id="initialAmount">₱0.00</strong></p>
                    <p>Final Payment (50%): <strong id="finalAmount">₱0.00</strong></p>
                    <p>Total: <strong id="totalAmount">₱0.00</strong></p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Your Information</label>
                <div class="info-box" style="background: var(--off-white); padding: 1rem; border-radius: var(--radius-md);">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>
                <p class="form-note" style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--warm-gray);">Your account information will be used for this submission.</p>
            </div>

            <div class="form-group">
                <label for="document" class="form-label">Upload Document *</label>
                <div class="file-upload-area" id="documentUpload">
                    <input type="file" name="document" id="document" accept=".pdf,.doc,.docx" required style="display: none;">
                    <button type="button" id="documentText" class="upload-button">Click to upload or drag and drop</button>
                    <p class="file-hint">PDF, DOC, or DOCX (Max 50MB)</p>
                </div>
                @error('document')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="instructions" class="form-label">Instructions for Service</label>
                <textarea name="instructions" id="instructions" class="form-input" rows="5" placeholder="Please provide specific instructions or requirements for this service. For example: 'Please focus on grammar and punctuation', 'Maintain the original tone', 'Highlight areas that need improvement', etc.">{{ old('instructions') }}</textarea>
                <p class="form-note" style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--warm-gray);">Provide clear instructions so the admin can follow your exact requirements.</p>
                @error('instructions')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="deadline" class="form-label">Deadline *</label>
                <input type="date" name="deadline" id="deadline" class="form-input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('deadline') }}">
                @error('deadline')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="payment-section">
                <h3>Initial Payment (50%)</h3>
                <p class="payment-instruction">Please pay 50% of the service fee via GCash before submitting.</p>
                
                <div class="gcash-info-box" style="background: var(--light-gray); border: 2px solid var(--professional-blue); border-radius: var(--radius-md); padding: 1.5rem; margin: 1.5rem 0;">
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
                        <strong>Note:</strong> Please send the payment to the GCash number above and upload the payment proof below.
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="initial_payment_proof" class="form-label">Upload Payment Proof *</label>
                    <div class="file-upload-area" id="proofUpload">
                        <input type="file" name="initial_payment_proof" id="initial_payment_proof" accept=".pdf,.jpg,.jpeg,.png" required style="display: none;">
                        <button type="button" id="proofText" class="upload-button">Click to upload payment proof</button>
                        <p class="file-hint">PDF, JPG, or PNG (Max 5MB)</p>
                    </div>
                    @error('initial_payment_proof')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="initial_payment_reference" class="form-label">GCash Reference Number *</label>
                    <input type="text" name="initial_payment_reference" id="initial_payment_reference" class="form-input" required value="{{ old('initial_payment_reference') }}" placeholder="Enter GCash reference number">
                    @error('initial_payment_reference')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary btn-large" id="submitBtn" disabled>Submit Submission</button>
                <p class="form-note">Submit button will be enabled once payment proof and reference number are provided.</p>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script src="{{ asset('js/submission.js') }}"></script>
@endpush
@endsection

