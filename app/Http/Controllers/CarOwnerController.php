<?php

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
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:car_owners',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
    
        // Generate a unique verification token
        $verificationToken = Str::random(64);
    
        // Create the car owner in the database
        $carOwner = CarOwner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'verification_token' => $verificationToken,
        ]);
    
        // Generate the verification URL
        $verificationUrl = route('carowner.verify', ['token' => $verificationToken]);
    
        // Send the verification email
        Mail::to($carOwner->email)->send(new \App\Mail\CarOwnerVerification($carOwner, $verificationUrl));
    
        // Return success message
        return redirect()->route('carowner.login')
            ->with('success', 'Registration successful! Please check your email to verify your account and set up your password.');
    }
    


    // // Handle email verification
    // public function verify($token)
    // {
    //     $carOwner = CarOwner::where('verification_token', $token)->first();

    //     if (!$carOwner) {
    //         return redirect()->route('carowner.login')
    //             ->with('error', 'Invalid verification token.');
    //     }

    //     return view('CarOwner.set-password', ['token' => $token]);
    // }

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

    public function sendVerificationEmail(CarOwner $carOwner)
    {
        // Generate verification token
        $token = Str::random(64);
        $carOwner->verification_token = $token;
        $carOwner->save();

        // Generate the verification URL
        $verificationUrl = route('carowner.setPassword', ['token' => $token]);

        // Send email
        Mail::to($carOwner->email)->send(new CarOwnerVerification($carOwner, $verificationUrl));

        return response()->json(['message' => 'Verification email sent']);
    }

    // Show the set password form
    public function showSetPasswordForm($token)
{
    $carOwner = CarOwner::where('password_set_token', $token)->first();

    if (!$carOwner) {
        return redirect()->route('carowner.login')->with('error', 'Invalid or expired token.');
    }

    return view('CarOwner.set-password', compact('token'));
}


    // Set the password
    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the car owner by the token
        $carOwner = CarOwner::where('password_set_token', $request->token)->first();

        if (!$carOwner) {
            return redirect()->route('carowner.login')->with('error', 'Invalid or expired token.');
        }

        // Set the new password
        $carOwner->password = Hash::make($request->password);
        $carOwner->password_set_token = null; // Clear the token after setting the password
        $carOwner->save();

        // Log the user in
        Auth::login($carOwner);

        return redirect()->route('carowner.dashboard')->with('success', 'Your password has been set successfully.');
    }

}
