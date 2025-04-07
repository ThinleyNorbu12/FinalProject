<?php

namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function showResetForm($token)
    {
        // Return the view with the token for the reset form
        return view('auth.reset', ['token' => $token]);
    }

    public function setPassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        
        // Find the user associated with the verification token
        $user = CarOwner::where('verification_token', $request->token)->first();
        
        // If the user does not exist, return an error
        if (!$user) {
            return back()->with('error', 'Invalid token');
        }
        
        // Update the user's password and clear the token
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();  // Mark the email as verified
        $user->verification_token = null; // Clear the token after password reset
        $user->save();
        
        // Log the user in
        Auth::login($user);
        
        // Redirect the user to the home page with a success message
        return redirect()->route('home')->with('success', 'Your account has been activated');
    }
}
