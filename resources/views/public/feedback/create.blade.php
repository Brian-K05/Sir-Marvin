@extends('layouts.public')

@section('title', 'Leave Feedback')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Leave Feedback</h1>
        <p class="page-subtitle">Share your experience with our service</p>
    </div>
</section>

<section class="feedback-form-section">
    <div class="container">
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="submission-info-box">
            <h3>Service: {{ $submission->service->name }}</h3>
            <p>Deadline: {{ $submission->deadline->format('F d, Y') }}</p>
        </div>

        <form action="{{ route('feedbacks.store', $submission->id) }}" method="POST" class="feedback-form">
            @csrf

            <div class="form-group">
                <label for="rating" class="form-label">Rating *</label>
                <div class="rating-input" id="ratingInput">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn" data-rating="{{ $i }}" aria-label="Rate {{ $i }} star">
                            <svg width="32" height="32" viewBox="0 0 20 20" fill="#E5E7EB" xmlns="http://www.w3.org/2000/svg" class="star-icon">
                                <path d="M10 15L4.175 18.5L5.35 11.975L0.7 7.5L7.325 6.875L10 1L12.675 6.875L19.3 7.5L14.65 11.975L15.825 18.5L10 15Z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="" required>
                @error('rating')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="comment" class="form-label">Comment (Optional)</label>
                <textarea name="comment" id="comment" rows="5" class="form-textarea" maxlength="1000" placeholder="Tell us about your experience...">{{ old('comment') }}</textarea>
                <small class="form-hint">Maximum 1000 characters</small>
                @error('comment')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Submit Feedback</button>
                <a href="{{ route('submissions.show', $submission->id) }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingInput = document.getElementById('ratingInput');
    const ratingField = document.getElementById('rating');
    const stars = ratingInput.querySelectorAll('.star-icon');
    let selectedRating = 0;

    ratingInput.querySelectorAll('.star-btn').forEach((btn, index) => {
        btn.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            ratingField.value = selectedRating;
            updateStars(selectedRating);
        });

        btn.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            updateStars(hoverRating, true);
        });
    });

    ratingInput.addEventListener('mouseleave', function() {
        updateStars(selectedRating);
    });

    function updateStars(rating, isHover = false) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.setAttribute('fill', '#FBBF24');
            } else {
                star.setAttribute('fill', '#E5E7EB');
            }
        });
    }

    // Form validation
    document.querySelector('.feedback-form').addEventListener('submit', function(e) {
        if (!ratingField.value) {
            e.preventDefault();
            alert('Please select a rating.');
        }
    });
});
</script>
@endpush
@endsection

