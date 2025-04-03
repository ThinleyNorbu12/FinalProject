<?php

namespace App\Http\Controllers;

use App\Models\CarOwner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CarOwnerPasswordSetupMail;

class CarOwnerController extends Controller {
    public function showRegisterForm()
        {
            return view('CarOwner.car_owner_register');
        }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:car_owners,email',
            'address' => 'required',
        ]);

        // Save car owner details
        $carOwner = CarOwner::create($request->only(['name', 'phone', 'email', 'address']));

        // Generate a password reset token
        $token = Str::random(60);

        // Create a user (optional, if they need to log in)
        $user = User::create([
            'name' => $carOwner->name,
            'email' => $carOwner->email,
            'password' => bcrypt('temporary_password'), // Temporary password
        ]);

        // Send email to set password
        Mail::to($carOwner->email)->send(new CarOwnerPasswordSetupMail($token));

        return back()->with('success', 'Registration successful! Check your email to set a password.');
    }


        
    public function setPassword(Request $request) {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', 'test@example.com')->first(); // Change this logic for real token usage

        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            return redirect('/login')->with('success', 'Password set successfully! You can now log in.');
        } else {
            return back()->withErrors(['token' => 'Invalid token!']);
        }
    }

}
