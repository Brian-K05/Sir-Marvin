@extends('layouts.public')

@section('title', 'Feedback Submitted')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Thank You!</h1>
        <p class="page-subtitle">Your feedback has been submitted</p>
    </div>
</section>

<section class="feedback-success-section">
    <div class="container">
        <div class="success-message">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 1.5rem;">
                <circle cx="32" cy="32" r="32" fill="#059669" opacity="0.1"/>
                <path d="M32 8C18.745 8 8 18.745 8 32C8 45.255 18.745 56 32 56C45.255 56 56 45.255 56 32C56 18.745 45.255 8 32 8ZM28 42L18 32L20.83 29.17L28 36.34L43.17 21.17L46 24L28 42Z" fill="#059669"/>
            </svg>
            <h2>Feedback Submitted Successfully</h2>
            <p>Thank you for taking the time to share your experience with us!</p>
            <p class="info-text">Your feedback is pending admin approval and will be displayed on our website once approved.</p>
            <div class="success-actions">
                <a href="{{ route('submissions.index') }}" class="btn-primary">View My Bookings</a>
                <a href="{{ route('home') }}" class="btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection

