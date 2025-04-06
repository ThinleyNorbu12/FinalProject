<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Password;

// class CarOwnerController extends Controller
// {
//     public function registerSubmit(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'phone' => 'required|string|max:20',
//             'email' => 'required|email|unique:users,email',
//             'address' => 'required|string|max:255',
//         ]);

//         // Create the user with empty password
//         $user = User::create([
//             'name' => $validated['name'],
//             'phone' => $validated['phone'],
//             'email' => $validated['email'],
//             'address' => $validated['address'],
//             'password' => '', // or use Hash::make(Str::random(10)) if needed
//         ]);

//         // Send password reset email
//         Password::sendResetLink(['email' => $user->email]);

//         return redirect()->route('carowner.login')->with('status', 'A password setup link has been sent to your email.');
//     }
// }

namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CarOwnerVerification;


class CarOwnerController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('CarOwner.register');
    }

    public function register(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:car_owners',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',  // Add password validation
        ]);

        // Generate verification token
        $verificationToken = Str::random(64);  // Define the verification token here

        // Create car owner in the database with the hashed password and verification token
        $carOwner = CarOwner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => bcrypt($validated['password']),  // Hash the password before storing it
            'verification_token' => $verificationToken,  // Add the generated verification token here
        ]);

        // Send verification email
        Mail::to($carOwner->email)->send(new CarOwnerVerification($carOwner, $verificationToken));

        // Redirect to login page with success message
        return redirect()->route('carowner.login')
            ->with('success', 'Registration successful! Please check your email to verify your account and set up your password.');
    }


    // Handle email verification
    public function verify($token)
    {
        $carOwner = CarOwner::where('verification_token', $token)->first();

        if (!$carOwner) {
            return redirect()->route('carowner.login')
                ->with('error', 'Invalid verification token.');
        }

        return view('CarOwner.set-password', ['token' => $token]);
    }

    // Handle password setup
    public function setPassword(Request $request)
    {
        // Validate input
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find car owner by verification token
        $carOwner = CarOwner::where('verification_token', $request->token)->first();

        if (!$carOwner) {
            return redirect()->route('carowner.login')
                ->with('error', 'Invalid verification token.');
        }

        // Update password and verification details
        $carOwner->password = Hash::make($request->password);
        $carOwner->email_verified_at = now();
        $carOwner->verification_token = null;
        $carOwner->save();

        // Log in the car owner
        Auth::guard('carowner')->login($carOwner);

        return redirect()->route('carowner.dashboard')
            ->with('success', 'Your password has been set and your account is now verified!');
    }

    // Show login form
    public function showLoginForm()
    {
        if (Auth::guard('carowner')->check()) {
            return redirect()->route('carowner.dashboard');
        }
        return view('CarOwner.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in
        if (Auth::guard('carowner')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('carowner.dashboard'));
        }

        // Return errors if login fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show the dashboard
    public function dashboard()
    {
        $carOwner = Auth::guard('carowner')->user();
        return view('CarOwner.dashboard', compact('carOwner'));
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('carowner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('carowner.login');
    }
}
// When logging in a car owner
// Auth::guard('carowner')->attempt($credentials, $request->remember);

// // When logging out a car owner
// Auth::guard('carowner')->logout();