@extends('layouts.public')

@section('title', 'Services')

@section('content')
<section class="page-header">
    <div class="container">
        <span class="section-label">What We Offer</span>
        <h1>Our Services</h1>
        <p class="page-subtitle">Professional editing and research consultation services tailored to your academic and professional needs</p>
    </div>
</section>

<section class="services-listing">
    <div class="container">
        <div class="services-grid-detailed">
            @forelse($services as $service)
            <div class="service-card-detailed">
                <div class="service-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" rx="12" fill="currentColor" opacity="0.1"/>
                        <path d="M24 16L28 20L24 24M20 20H28" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>{{ $service->name }}</h3>
                <p class="service-description">{{ $service->description }}</p>
                <div class="service-pricing">
                    <span class="price-label">Starting from</span>
                    <span class="price-amount">₱{{ number_format($service->price, 2) }}</span>
                </div>
                <div class="service-payment-info">
                    <div class="payment-breakdown">
                        <div class="payment-item">
                            <span class="payment-label">Initial Payment ({{ $service->initial_payment_percentage }}%):</span>
                            <span class="payment-amount">₱{{ number_format($service->initial_payment_amount, 2) }}</span>
                        </div>
                        <div class="payment-item">
                            <span class="payment-label">Final Payment:</span>
                            <span class="payment-amount">₱{{ number_format($service->price - $service->initial_payment_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                @auth
                    <a href="{{ route('submissions.create', ['service' => $service->id]) }}" class="btn-primary service-btn">
                        <span>Book This Service</span>
                    </a>
                @else
                    <a href="{{ route('login') }}?redirect={{ urlencode(route('submissions.create', ['service' => $service->id])) }}" class="btn-primary service-btn">
                        <span>Login to Book</span>
                    </a>
                @endauth
            </div>
            @empty
            <div class="no-services">
                <p>No services available at this time. Please check back later.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

