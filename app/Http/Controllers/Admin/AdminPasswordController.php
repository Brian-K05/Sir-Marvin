<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordChangeVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AdminPasswordController extends Controller
{
    /**
     * Show the password change form.
     */
    public function show()
    {
        return view('admin.password.change');
    }

    /**
     * Update the admin's password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $admin = Auth::guard('admin')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        // Update password
        $admin->password = Hash::make($request->password);
        $admin->save();

        // Send verification email
        try {
            Mail::to($admin->email)->send(new PasswordChangeVerificationMail($admin));
        } catch (\Exception $e) {
            // Log error but don't fail the password change
            \Log::error('Failed to send password change verification email: ' . $e->getMessage());
        }

        return redirect()->route('admin.password.change')
            ->with('success', 'Password changed successfully! A verification email has been sent to your email address.');
    }
}

