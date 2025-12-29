@extends('admin.layout')

@section('title', 'Services')

@section('content')
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Services Management</h2>
        <div class="admin-section-actions">
            <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary">
                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
                    <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Create New Service
            </a>
        </div>
    </div>
    
    <div class="admin-table-container">
        <table class="admin-table-modern">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Initial %</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td><span class="admin-table-id">#{{ $service->id }}</span></td>
                    <td><span class="admin-table-text" style="font-weight: 600;">{{ $service->name }}</span></td>
                    <td><span class="admin-table-text">{{ Str::limit($service->description, 80) }}</span></td>
                    <td><span class="admin-table-amount">₱{{ number_format($service->price, 2) }}</span></td>
                    <td><span class="admin-table-text">{{ $service->initial_payment_percentage }}%</span></td>
                    <td>
                        @if($service->is_active)
                            <span class="admin-status-badge admin-status-completed">Active</span>
                        @else
                            <span class="admin-status-badge" style="background: rgba(107, 114, 128, 0.1); color: #6B7280; border-color: rgba(107, 114, 128, 0.2);">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="admin-action-buttons">
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="admin-btn admin-btn-sm admin-btn-primary">Edit</a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="admin-table-empty">
                        <div class="admin-empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>No services found</p>
                            <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary" style="margin-top: 1rem;">Create First Service</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($services->hasPages())
    <div class="admin-pagination">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection

