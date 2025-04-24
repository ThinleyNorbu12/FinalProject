<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    // Show the password reset form
    public function showResetForm(Request $request, $token = null)
{
    return view('customer.auth.passwords.reset')->with(
        ['token' => $token, 'email' => $request->email]
    );
}


    // Handle the reset password form submission
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $response = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('customer.login')->with('status', 'Password reset successfully!');
        }

        return back()->withErrors(['email' => [trans($response)]]);
    }
}

