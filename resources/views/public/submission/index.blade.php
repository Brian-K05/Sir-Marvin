@extends('layouts.public')

@section('title', 'My Bookings')

@section('content')
<section class="page-header">
    <div class="container">
        <span class="section-label">My Bookings</span>
        <h1>My Bookings</h1>
        <p class="page-subtitle">Monitor and track all your service bookings</p>
    </div>
</section>

<section class="bookings-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($submissions->count() > 0)
            <div class="bookings-grid">
                @foreach($submissions as $submission)
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="booking-service">
                                <h3>{{ $submission->service->name }}</h3>
                                <span class="booking-id">Booking #{{ $submission->id }}</span>
                            </div>
                            <span class="status-badge status-{{ str_replace('_', '-', $submission->status) }}">
                                {{ ucwords(str_replace('_', ' ', $submission->status)) }}
                            </span>
                        </div>
                        
                        <div class="booking-details">
                            <div class="detail-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 8C9.10457 8 10 7.10457 10 6C10 4.89543 9.10457 4 8 4C6.89543 4 6 4.89543 6 6C6 7.10457 6.89543 8 8 8Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 13.3333C2 11.1242 3.79121 9.33333 6 9.33333H10C12.2088 9.33333 14 11.1242 14 13.3333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span>{{ $submission->client_name }}</span>
                            </div>
                            <div class="detail-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 4H14V12C14 12.5304 13.7893 13.0391 13.4142 13.4142C13.0391 13.7893 12.5304 14 12 14H4C3.46957 14 2.96086 13.7893 2.58579 13.4142C2.21071 13.0391 2 12.5304 2 12V4Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 4L8 8L14 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $submission->client_email }}</span>
                            </div>
                            <div class="detail-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M8 5V8L10 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span>Deadline: {{ $submission->deadline->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M6 6H10M6 8H10M6 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span>Initial Payment: 
                                    <span class="payment-status status-{{ $submission->initial_payment_status }}">
                                        {{ ucfirst($submission->initial_payment_status) }}
                                    </span>
                                </span>
                            </div>
                            @if($submission->status === 'awaiting_final' || $submission->status === 'completed')
                                <div class="detail-item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M6 6H10M6 8H10M6 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <span>Final Payment: 
                                        <span class="payment-status status-{{ $submission->final_payment_status }}">
                                            {{ ucfirst($submission->final_payment_status) }}
                                        </span>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="booking-actions">
                            <a href="{{ route('submissions.show', $submission->id) }}" class="btn-primary">
                                <span>View Details</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M40 40C44.4183 40 48 36.4183 48 32C48 27.5817 44.4183 24 40 24C35.5817 24 32 27.5817 32 32C32 36.4183 35.5817 40 40 40Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M20 56.6667C20 50.1242 25.3731 44.6667 32 44.6667H48C54.6269 44.6667 60 50.1242 60 56.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M40 20V60M20 40H60" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <h3>No Bookings Yet</h3>
                <p>You haven't made any bookings yet. Start by booking a service!</p>
                <a href="{{ route('submissions.create') }}" class="btn-primary">
                    <span>Book a Service</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

