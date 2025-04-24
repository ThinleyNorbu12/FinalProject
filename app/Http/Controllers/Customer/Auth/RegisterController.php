<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CustomerSetPasswordMail; // Make sure you have this mail class

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        // Validate registration fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:20|unique:customers', // Phone validation
            'cid_no' => 'required|string|max:20|unique:customers', // CID validation
        ]);

        // Create the customer record without a password
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cid_no' => $request->cid_no,
        ]);

        // Generate a random token
        $token = Str::random(64);

        // Send the email to the customer with the token
        Mail::to($customer->email)->send(new CustomerSetPasswordMail($token));

        // Redirect to login page with success message
        return redirect()->route('customer.login')
            ->with('success', 'Registration successful! Please check your email to set your password.');
    }
}
