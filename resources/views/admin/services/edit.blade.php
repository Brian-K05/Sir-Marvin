@extends('admin.layout')

@section('title', 'Edit Service')

@section('content')
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Edit Service</h2>
        <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-secondary">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                <path d="M12 5L7 10L12 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to Services
        </a>
    </div>

    <div class="admin-form-card">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            <div class="admin-form-group">
                <label for="name" class="admin-form-label">Service Name *</label>
                <input type="text" name="name" id="name" class="admin-form-input @error('name') admin-form-input-error @enderror" required value="{{ old('name', $service->name) }}" placeholder="Enter service name">
                @error('name')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-group">
                <label for="description" class="admin-form-label">Description *</label>
                <textarea name="description" id="description" class="admin-form-textarea @error('description') admin-form-input-error @enderror" required rows="5" placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label for="price" class="admin-form-label">Price (₱) *</label>
                    <input type="number" name="price" id="price" class="admin-form-input @error('price') admin-form-input-error @enderror" step="0.01" min="0" required value="{{ old('price', $service->price) }}" placeholder="0.00">
                    @error('price')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-group">
                    <label for="initial_payment_percentage" class="admin-form-label">Initial Payment % *</label>
                    <input type="number" name="initial_payment_percentage" id="initial_payment_percentage" class="admin-form-input @error('initial_payment_percentage') admin-form-input-error @enderror" min="1" max="100" required value="{{ old('initial_payment_percentage', $service->initial_payment_percentage) }}" placeholder="50">
                    @error('initial_payment_percentage')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="admin-checkbox">
                    <span>Service is active</span>
                </label>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                        <path d="M16 2L18 4L8 14L4 10L6 8L8 10L16 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Update Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

