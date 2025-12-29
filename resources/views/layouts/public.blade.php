<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Professional Grammar & Editing Service') - {{ config('app.name', 'Marvin Dominic B. Buena') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">Marvin Dominic B. Buena</a>
                <nav class="main-nav">
                    <ul class="nav-menu">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                        <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                        @auth
                            <li><a href="{{ route('submissions.create') }}" class="btn-primary nav-cta">Book Service</a></li>
                            <li><a href="{{ route('submissions.index') }}" class="nav-link {{ request()->routeIs('submissions.index') ? 'active' : '' }}">My Bookings</a></li>
                            <li><a href="#" class="nav-link" id="profileModalBtn" onclick="event.preventDefault(); const modal = document.getElementById('profileModal'); if(modal) { modal.style.display = 'flex'; setTimeout(() => modal.classList.add('active'), 10); document.body.style.overflow = 'hidden'; }">Profile</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a></li>
                            <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Sign Up</a></li>
                        @endauth
                    </ul>
                    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p><a href="mailto:marvnbuena@gmail.com">marvnbuena@gmail.com</a></p>
                    <p><a href="tel:09223549524">09223549524</a></p>
                </div>
                <div class="footer-section">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="{{ route('services.index') }}">Grammar Validation</a></li>
                        <li><a href="{{ route('services.index') }}">Paraphrasing</a></li>
                        <li><a href="{{ route('services.index') }}">Thematic Analysis</a></li>
                        <li><a href="{{ route('services.index') }}">Methodology Assistance</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Professional Grammar & Editing Service</p>
                <p>&copy; {{ date('Y') }} Marvin Dominic B. Buena. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    @auth
    <!-- Profile Modal -->
    <div class="modal-overlay" id="profileModal" onclick="if(event.target === this) { this.classList.remove('active'); setTimeout(() => this.style.display = 'none', 300); document.body.style.overflow = ''; }">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Profile</h3>
                <button class="modal-close" id="profileModalClose" aria-label="Close modal" onclick="const modal = document.getElementById('profileModal'); if(modal) { modal.classList.remove('active'); setTimeout(() => modal.style.display = 'none', 300); document.body.style.overflow = ''; }">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <a href="#" class="modal-item" id="profileEditModalBtn" onclick="event.preventDefault(); const profileModal = document.getElementById('profileModal'); const editModal = document.getElementById('profileEditModal'); if(profileModal) { profileModal.classList.remove('active'); setTimeout(() => profileModal.style.display = 'none', 300); } if(editModal) { editModal.style.display = 'flex'; setTimeout(() => editModal.classList.add('active'), 10); document.body.style.overflow = 'hidden'; }">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 12C5.58172 12 2 14.6863 2 18V20H18V18C18 14.6863 14.4183 12 10 12Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Update Profile</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="modal-item-arrow">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#" class="modal-item" id="passwordChangeModalBtn" onclick="event.preventDefault(); const profileModal = document.getElementById('profileModal'); const passwordModal = document.getElementById('passwordChangeModal'); if(profileModal) { profileModal.classList.remove('active'); setTimeout(() => profileModal.style.display = 'none', 300); } if(passwordModal) { passwordModal.style.display = 'flex'; setTimeout(() => passwordModal.classList.add('active'), 10); document.body.style.overflow = 'hidden'; }">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 7.5C15 6.11929 13.8807 5 12.5 5C11.1193 5 10 6.11929 10 7.5M15 7.5C15 8.88071 13.8807 10 12.5 10C11.1193 10 10 8.88071 10 7.5M15 7.5H17.5C18.3284 7.5 19 8.17157 19 9V16.5C19 17.3284 18.3284 18 17.5 18H2.5C1.67157 18 1 17.3284 1 16.5V9C1 8.17157 1.67157 7.5 2.5 7.5H5M5 7.5C5 6.11929 6.11929 5 7.5 5C8.88071 5 10 6.11929 10 7.5M5 7.5C5 8.88071 6.11929 10 7.5 10C8.88071 10 10 8.88071 10 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Change Password</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="modal-item-arrow">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="modal-divider"></div>
                <a href="{{ route('contact') }}" class="modal-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 6V10M10 14H10.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Help</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="modal-item-arrow">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <form method="POST" action="{{ route('profile.destroy') }}" class="modal-item-form">
                    @csrf
                    @method('delete')
                    <button type="submit" class="modal-item-btn delete-account" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5H5H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 5V3C8 2.46957 8.21071 1.96086 8.58579 1.58579C8.96086 1.21071 9.46957 1 10 1C10.5304 1 11.0391 1.21071 11.4142 1.58579C11.7893 1.96086 12 2.46957 12 3V5M15 5V17C15 17.5304 14.7893 18.0391 14.4142 18.4142C14.0391 18.7893 13.5304 19 13 19H7C6.46957 19 5.96086 18.7893 5.58579 18.4142C5.21071 18.0391 5 17.5304 5 17V5H15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Delete Account</span>
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}" class="modal-item-form">
                    @csrf
                    <button type="submit" class="modal-item-btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L2 12M2 12L7 7M2 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Edit Modal -->
    <div class="modal-overlay" id="profileEditModal" onclick="if(event.target === this) { this.classList.remove('active'); setTimeout(() => this.style.display = 'none', 300); document.body.style.overflow = ''; }">
        <div class="modal-content modal-content-large">
            <div class="modal-header">
                <h3>Update Profile</h3>
                <button class="modal-close" id="profileEditModalClose" aria-label="Close modal" onclick="const modal = document.getElementById('profileEditModal'); if(modal) { modal.classList.remove('active'); setTimeout(() => modal.style.display = 'none', 300); document.body.style.overflow = ''; }">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                @if(session('status') === 'profile-updated')
                    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                        {{ __('Profile updated successfully!') }}
                    </div>
                @endif

                @if(session('status') === 'email-updated')
                    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                        {{ __('Email updated successfully! A verification email has been sent to your new email address. Please check your inbox and verify it to complete the change.') }}
                    </div>
                @endif

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="profile-edit-form" id="profileUpdateForm">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="edit-name" class="form-label">{{ __('Name') }}</label>
                        <input id="edit-name" name="name" type="text" class="form-input" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name" />
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit-email" class="form-label">{{ __('Email') }}</label>
                        <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                            <input id="edit-email" name="email" type="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" readonly style="flex: 1; background-color: #f5f5f5; cursor: not-allowed;" />
                            <button type="button" id="changeEmailBtn" class="btn-secondary" style="white-space: nowrap; padding: 0.75rem 1rem;">{{ __('Change Email') }}</button>
                        </div>
                        <input type="hidden" id="email-changed" name="email_changed" value="0" />
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div class="email-verification-notice">
                                <p class="text-sm mt-2">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="text-link" type="button">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="text-sm mt-2 text-success">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                        <button type="button" class="btn-secondary" onclick="const modal = document.getElementById('profileEditModal'); if(modal) { modal.classList.remove('active'); setTimeout(() => modal.style.display = 'none', 300); document.body.style.overflow = ''; }">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    <div class="modal-overlay" id="passwordChangeModal" onclick="if(event.target === this) { this.classList.remove('active'); setTimeout(() => this.style.display = 'none', 300); document.body.style.overflow = ''; }">
        <div class="modal-content modal-content-large">
            <div class="modal-header">
                <h3>Change Password</h3>
                <button class="modal-close" id="passwordChangeModalClose" aria-label="Close modal" onclick="const modal = document.getElementById('passwordChangeModal'); if(modal) { modal.classList.remove('active'); setTimeout(() => modal.style.display = 'none', 300); document.body.style.overflow = ''; }">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                @if(session('status') === 'password-updated')
                    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                        {{ __('Password updated successfully!') }}
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}" class="profile-edit-form">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="change-current-password" class="form-label">{{ __('Current Password') }}</label>
                        <div class="password-input-wrapper">
                            <input id="change-current-password" name="current_password" type="password" class="form-input" autocomplete="current-password" required />
                            <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.33333 3.33333L16.6667 16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="change-new-password" class="form-label">{{ __('New Password') }}</label>
                        <div class="password-input-wrapper">
                            <input id="change-new-password" name="password" type="password" class="form-input" autocomplete="new-password" required />
                            <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.33333 3.33333L16.6667 16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        @error('password', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="change-password-confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="password-input-wrapper">
                            <input id="change-password-confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" required />
                            <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <path d="M2.5 10C2.5 10 5.83333 4.16667 10 4.16667C14.1667 4.16667 17.5 10 17.5 10C17.5 10 14.1667 15.8333 10 15.8333C5.83333 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.33333 3.33333L16.6667 16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                        <button type="button" class="btn-secondary" onclick="const modal = document.getElementById('passwordChangeModal'); if(modal) { modal.classList.remove('active'); setTimeout(() => modal.style.display = 'none', 300); document.body.style.overflow = ''; }">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Email Modal -->
    <div class="modal-overlay" id="changeEmailModal" onclick="if(event.target === this) { closeChangeEmailModal(); }">
        <div class="modal-content modal-content-large">
            <div class="modal-header">
                <h3>Change Email</h3>
                <button class="modal-close" id="changeEmailModalClose" aria-label="Close modal" onclick="closeChangeEmailModal();">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <!-- Step 1: Password Verification -->
                <div id="changeEmailStep1">
                    <p style="margin-bottom: 1.5rem; color: var(--charcoal);">Please enter your current password to change your email address.</p>
                    <form id="verifyPasswordForm" class="profile-edit-form" data-verify-route="{{ route('profile.verify-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="verify-password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="verify-password" name="password" type="password" class="form-input" autocomplete="current-password" required />
                            <span id="password-error" class="form-error" style="display: none;"></span>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">{{ __('Verify Password') }}</button>
                            <button type="button" class="btn-secondary" onclick="closeChangeEmailModal();">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>

                <!-- Step 2: New Email Input -->
                <div id="changeEmailStep2" style="display: none;">
                    <p style="margin-bottom: 1.5rem; color: var(--charcoal);">Enter your new email address.</p>
                    <form id="changeEmailForm" method="post" action="{{ route('profile.update-email') }}" class="profile-edit-form">
                        @csrf
                        <div class="form-group">
                            <label for="new-email" class="form-label">{{ __('New Email') }}</label>
                            <input id="new-email" name="email" type="email" class="form-input" value="" required autocomplete="username" />
                            @error('email', 'updateEmail')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">{{ __('Save New Email') }}</button>
                            <button type="button" class="btn-secondary" onclick="resetChangeEmailModal();">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth
</body>
</html>

