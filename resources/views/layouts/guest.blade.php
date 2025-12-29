<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Login') - {{ config('app.name', 'Marvin Dominic B. Buena') }}</title>
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
                            <li><a href="{{ route('login') }}?redirect={{ urlencode(route('submissions.create')) }}" class="btn-primary nav-cta">Book Service</a></li>
                            @auth
                                <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="nav-link-btn" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer; font-size: inherit; font-family: inherit;">Logout</button>
                                    </form>
                                </li>
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
            <div class="auth-container">
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
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
    </body>
</html>
