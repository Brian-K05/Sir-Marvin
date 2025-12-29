<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = $user->email;
        $oldName = $user->name;
        
        $user->fill($request->validated());

        // Check if email changed before saving
        $emailChanged = $user->isDirty('email');
        $nameChanged = $user->isDirty('name');

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update all submissions belonging to this user with the new name
        // Note: Email changes are handled separately via updateEmail method
        if ($nameChanged) {
            Submission::where('client_email', $oldEmail)
                ->update([
                    'client_name' => $user->name,
                ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('status', 'profile-updated');
    }

    /**
     * Verify password for email change.
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Store password verification in session
        $request->session()->put('email_change_verified', true);
        $request->session()->put('email_change_verified_at', now());

        return response()->json(['success' => true]);
    }

    /**
     * Update the user's email address.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        // Check if password was verified
        if (!$request->session()->get('email_change_verified')) {
            return redirect()->back()->withErrors(['email' => 'Please verify your password first.'], 'updateEmail');
        }

        // Check if verification is still valid (within 5 minutes)
        $verifiedAt = $request->session()->get('email_change_verified_at');
        if (!$verifiedAt || now()->diffInMinutes($verifiedAt) > 5) {
            $request->session()->forget(['email_change_verified', 'email_change_verified_at']);
            return redirect()->back()->withErrors(['email' => 'Password verification expired. Please try again.'], 'updateEmail');
        }

        $user = $request->user();
        $oldEmail = $user->email;

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
        ], [], [
            'email' => 'email address',
        ]);

        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        // Send verification email to new address
        $user->sendEmailVerificationNotification();

        // Update all submissions belonging to this user with the new email
        Submission::where('client_email', $oldEmail)
            ->update([
                'client_email' => $user->email,
            ]);

        // Clear password verification session
        $request->session()->forget(['email_change_verified', 'email_change_verified_at']);

        return redirect()->back()->with('status', 'email-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
