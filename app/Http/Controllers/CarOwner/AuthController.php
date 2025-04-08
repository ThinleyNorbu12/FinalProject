<?php

namespace App\Http\Controllers\CarOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\CarOwner;


class AuthController extends Controller
{

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
    
        // Check if the email exists in the CarOwner table
        $carOwner = CarOwner::where('email', $request->email)->first();
    
        // If car owner exists and password is correct
        if ($carOwner && Hash::check($request->password, $carOwner->password)) {
            // Log in the car owner
            Auth::guard('carowner')->login($carOwner);
    
            // Redirect to the dashboard or wherever you want
            return redirect()->route('carowner.dashboard');
        } else {
            // If login fails
            return back()->withErrors(['email' => 'Invalid credentials. Please try again.']);
        }
    }
    
}

