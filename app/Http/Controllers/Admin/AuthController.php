<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    // Handle registration and send set password link
    
public function register(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins',
    ]);

    // Create Admin without password
    $admin = Admin::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    // Send password reset link
    $status = Password::broker('admins')->sendResetLink([
        'email' => $admin->email
    ]);

    if ($status === Password::RESET_LINK_SENT) {
        return redirect()->route('admin.login')->with('success', 'Admin registered! Password setup link has been sent to their email.');
    } else {
        return back()->with('error', 'Failed to send password reset link. Please try again later.');
    }
}
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email-admin'); // You'll create this view
    }

    /**
     * Send reset link to admin email
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent to your email!')
            : back()->withErrors(['email' => 'We couldn\'t find a user with that email address.']);
    }
}