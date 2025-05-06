<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; // Add this import
use Illuminate\Support\Facades\Session; // You're using Session too, so add this
use App\Models\CarBooking; // Also add this for CarBooking::create

class LoginController extends Controller
{
   
    public function showLoginForm(Request $request)
    {
        // Save the redirect URL to session if passed
        if ($request->has('redirectTo')) {
            session(['url.intended' => $request->redirectTo]);
        }

        return view('customer.auth.login');
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {

            // ✅ Handle car booking if session has booking data
            if (Session::has('booking_data')) {
                $bookingData = Session::get('booking_data');

                $bookingRecord = [
                    'car_id' => $bookingData['car_id'],
                    'pickup_location' => $bookingData['pickup_location'],
                    'pickup_date' => $bookingData['pickup_date'],
                    'dropoff_location' => $bookingData['drop_location'],
                    'dropoff_date' => $bookingData['return_date'],
                ];

                if (Schema::hasColumn('car_bookings', 'customer_id')) {
                    $bookingRecord['customer_id'] = Auth::guard('customer')->id();
                }

                CarBooking::create($bookingRecord);
                Session::forget('booking_data');

                return redirect()->route('booking.summary')
                    ->with('success', 'You have successfully logged in and your car has been booked!');
            }

            // ✅ Handle redirect after normal login
            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'Welcome back!');
        }

        // ❌ Login failed
        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ])->withInput();

    }   

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'Logged out successfully.');
    }
}
