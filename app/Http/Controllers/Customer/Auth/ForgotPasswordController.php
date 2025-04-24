<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    // Show the form to request a password reset link
    public function showLinkRequestForm()
    {
        return view('customer.auth.passwords.email');
    }

    // Send the password reset link email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? back()->with('status', trans($response))
                    : back()->withErrors(['email' => trans($response)]);
    }
}
