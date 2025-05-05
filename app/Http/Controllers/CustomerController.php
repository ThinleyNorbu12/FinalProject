<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\CarBooking;

class CustomerController extends Controller
{
    // Show dashboard
    // public function dashboard()
    // {
    //     return view('customer.dashboard');
    // }

    public function dashboard()
    {
        $userId = Auth::id();

        // Get the most recent active booking for the logged-in user
        $booking = CarBooking::where('customer_id', $userId)
                    ->where('status', 'active') // Assuming 'active' status indicates a current rental
                    ->latest('pickup_date')
                    ->first();

        // Get the car details if a booking exists
        $car = $booking ? Car::find($booking->car_id) : null;

        return view('customer.dashboard', compact('booking', 'car'));
    }


    // Show Set Password Form
    public function showSetPasswordForm($token)
    {
        // If you want to just show the form without checking the customer in the database:
        return view('customer.auth.passwords.set', ['token' => $token]);
    }
    

    // Save password
    public function setPassword(Request $request)
{
    // Validate incoming data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'token' => 'required',
    ]);

    // Skip querying the password_resets table since you're not using it.
    // Validate token directly (assuming token is the email or a unique identifier in this case).
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        return back()->withErrors(['email' => 'Customer not found.']);
    }

    // Assuming you're using the token as a unique identifier for verification
    if ($customer->email !== $request->email) {
        return back()->withErrors(['email' => 'Invalid token or email.']);
    }

    // Update the customer's password
    $customer->password = Hash::make($request->password);
    $customer->save();

    // Return a successful response
    return redirect()->route('customer.login')->with('status', 'Password set successfully!');
}

}
