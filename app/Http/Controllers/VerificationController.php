<?php
namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CarOwnerVerification;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    // Handle email verification
    // Handle email verification
    public function verify($token)
    {
        // Find the car owner by the verification token
        $carOwner = CarOwner::where('verification_token', $token)->first();
    
        if (!$carOwner) {
            return redirect()->route('carowner.login')->with('error', 'Invalid verification token.');
        }
    
        // Mark the email as verified
        $carOwner->email_verified_at = now();
        $carOwner->verification_token = null; // Remove verification token
    
        // Generate a token to set the password
        $passwordSetToken = Str::random(64);
        $carOwner->password_set_token = $passwordSetToken;
    
        $carOwner->save();
    
        // Generate the Set Password URL
        $verificationUrl = route('carowner.set-password', ['token' => $passwordSetToken]);
    
        // Send the email using your CarOwnerVerification Mailable
        Mail::to($carOwner->email)->send(new CarOwnerVerification($carOwner, $verificationUrl));
    
        // 🔁 Redirect directly to the Set Password page
        return redirect()->route('carowner.set-password', ['token' => $passwordSetToken])
            ->with('success', 'Your email has been verified. Please set your password.');
    }
    // Show the form for setting up the password
    public function showPasswordForm($token)
    {
        return view('auth.set-password', compact('token'));
    }

   
}
