<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Store redirect URL if provided
        if ($request->has('redirect')) {
            $request->session()->put('url.intended', $request->get('redirect'));
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Regenerate session to prevent session fixation attacks
        // Laravel preserves authentication state during regeneration
        $request->session()->regenerate();

        // Check which guard is authenticated AFTER regeneration
        // This is the definitive check - don't rely on email lookup
        if (Auth::guard('admin')->check()) {
            // Admin is authenticated, redirect to admin dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // Regular user is authenticated, redirect to home or intended URL
        if (Auth::guard('web')->check()) {
            $intended = $request->session()->pull('url.intended', route('home'));
            return redirect($intended);
        }

        // Fallback: authentication failed (shouldn't happen if authenticate() succeeded)
        return redirect()->route('login')->withErrors([
            'email' => 'Authentication failed. Please try again.'
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout from both guards to ensure clean state
        // This prevents stale authentication state from persisting
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        // Invalidate and regenerate session to clear all authentication data
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
