<?php

namespace App\Http\Controllers\CarOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function registerSubmit(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'email' => 'required|email|unique:users,email',
    //         'address' => 'required|string|max:255',
    //     ]);

    //     // Create the user with empty password
    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'phone' => $validated['phone'],
    //         'email' => $validated['email'],
    //         'address' => $validated['address'],
    //         'password' => '', // or use Hash::make(Str::random(10)) if needed
    //     ]);

    //     // Send password reset email
    //     Password::sendResetLink(['email' => $user->email]);

    //     return redirect()->route('carowner.login')->with('status', 'A password setup link has been sent to your email.');
    // }

    // 👇 ADD THIS METHOD
    public function showLoginForm()
    {
        return view('CarOwner.login');
    }

    // 👇 ADD THIS METHOD
    public function login(Request $request)
{
    // Validate the request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Check if the email exists
    $user = User::where('email', $request->email)->first();

    // If user exists and password is correct
    if ($user && Hash::check($request->password, $user->password)) {
        // Log in the user
        Auth::login($user);

        // Redirect to the dashboard or wherever you want
        return redirect()->route('carowner.dashboard');
    } else {
        // If login fails
        return back()->withErrors(['email' => 'Invalid credentials. Please try again.']);
    }
}
}

