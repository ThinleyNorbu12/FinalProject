<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class CarOwnerController extends Controller
{
    public function registerSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
        ]);

        // Create the user with empty password
        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'password' => '', // or use Hash::make(Str::random(10)) if needed
        ]);

        // Send password reset email
        Password::sendResetLink(['email' => $user->email]);

        return redirect()->route('carowner.login')->with('status', 'A password setup link has been sent to your email.');
    }
}
