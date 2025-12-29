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
        try {
            $request->authenticate();

            // Regenerate session to prevent session fixation attacks
            // Laravel preserves authentication state during regeneration
            try {
                $request->session()->regenerate();
            } catch (\Exception $e) {
                // If session regeneration fails, log it but continue
                \Log::warning('Session regeneration failed: ' . $e->getMessage());
                // Try to regenerate token instead
                $request->session()->regenerateToken();
            }

            // Check which guard is authenticated AFTER regeneration
            // This is the definitive check - don't rely on email lookup
            if (Auth::guard('admin')->check()) {
                // Admin is authenticated, redirect to admin dashboard
                try {
                    return redirect()->intended(route('admin.dashboard'));
                } catch (\Exception $e) {
                    \Log::error('Admin redirect failed: ' . $e->getMessage());
                    // Fallback to direct URL
                    return redirect('/admin/dashboard');
                }
            }

            // Regular user is authenticated, redirect to home or intended URL
            if (Auth::guard('web')->check()) {
                try {
                    $intended = $request->session()->pull('url.intended', route('home'));
                    return redirect($intended);
                } catch (\Exception $e) {
                    \Log::error('User redirect failed: ' . $e->getMessage());
                    // Fallback to home
                    return redirect('/');
                }
            }

            // Fallback: authentication failed (shouldn't happen if authenticate() succeeded)
            return redirect()->route('login')->withErrors([
                'email' => 'Authentication failed. Please try again.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->withErrors([
                'email' => 'An error occurred during login. Please try again.'
            ]);
        }
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
