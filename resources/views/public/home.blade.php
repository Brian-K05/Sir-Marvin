@extends('layouts.public')

@section('title', 'Home')

@section('content')
@if(session('success'))
    <div class="alert alert-success" style="margin: 2rem auto; max-width: 1200px; padding: 1rem 1.5rem; background: rgba(5, 150, 105, 0.1); color: #059669; border: 1px solid rgba(5, 150, 105, 0.2); border-radius: 8px; text-align: center; font-weight: 500;">
        {{ session('success') }}
    </div>
@endif

<section class="hero">
    <div class="hero-background"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-center">
                <div class="hero-badge">Professional Editing Services</div>
                <h1 class="hero-title">Refine Your Ideas.<br>Perfect Your Prose.</h1>
                <p class="hero-subtitle">Academic excellence through meticulous editing, research consultation, and scholarly support. Transform your documents with expert precision.</p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ route('submissions.create') }}" class="btn-primary btn-large">
                            <span>Book a Service</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('submissions.create')) }}" class="btn-primary btn-large">
                            <span>Login to Book</span>
                        </a>
                    @endauth
                    <a href="{{ route('services.index') }}" class="btn-secondary btn-large">View Services</a>
                </div>
            </div>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number">5+</div>
                <div class="stat-label">Services</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Quality</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </div>
</section>

<section class="trust-indicators">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Why Choose Us</span>
            <h2>Excellence in Every Detail</h2>
        </div>
        <div class="indicators-grid">
            <div class="indicator-card">
                <div class="indicator-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="currentColor" opacity="0.1"/>
                        <path d="M20 12L24 16L20 20M16 16H24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Academic Credentials</h3>
                <p>Course Manager at SEAMEO INNOTECH with published research in peer-reviewed journals</p>
            </div>
            <div class="indicator-card">
                <div class="indicator-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="currentColor" opacity="0.1"/>
                        <path d="M20 12V28M12 20H28" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Expertise</h3>
                <p>Specialized in grammar validation, paraphrasing, thematic analysis, and methodology assistance</p>
            </div>
            <div class="indicator-card">
                <div class="indicator-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="currentColor" opacity="0.1"/>
                        <path d="M20 14L24 18L20 22M16 18H24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Professional Standards</h3>
                <p>Meticulous attention to detail ensuring academic integrity and scholarly excellence</p>
            </div>
            <div class="indicator-card">
                <div class="indicator-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="currentColor" opacity="0.1"/>
                        <path d="M20 12L24 16L20 20M16 16H24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Research Background</h3>
                <p>Published author with expertise in stylistic analysis and academic writing</p>
            </div>
        </div>
    </div>
</section>

@if($feedbacks && $feedbacks->count() > 0)
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Client Reviews</span>
            <h2>What Our Clients Say</h2>
            <p class="section-description">Read feedback from clients who have used our services</p>
        </div>
        <div class="testimonials-grid">
            @foreach($feedbacks as $feedback)
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            {{ strtoupper(substr($feedback->user->name, 0, 1)) }}
                        </div>
                        <div class="author-info">
                            <h4>{{ $feedback->user->name }}</h4>
                            <p class="author-service">{{ $feedback->submission->service->name }}</p>
                        </div>
                    </div>
                    <div class="testimonial-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="{{ $i <= $feedback->rating ? '#FBBF24' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 15L4.175 18.5L5.35 11.975L0.7 7.5L7.325 6.875L10 1L12.675 6.875L19.3 7.5L14.65 11.975L15.825 18.5L10 15Z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                @if($feedback->comment)
                    <p class="testimonial-comment">{{ $feedback->comment }}</p>
                @endif
                <p class="testimonial-date">{{ $feedback->created_at->format('M d, Y') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

