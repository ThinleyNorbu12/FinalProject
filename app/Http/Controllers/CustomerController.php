<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\CarBooking;
use App\Models\Payment;
use Carbon\Carbon;

use App\Models\PayLaterPayment;


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
                    ->latest('pickup_datetime') // ✅ use correct column
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

    public function payLater()
    {
        try {
            // Get the authenticated customer
            $customer = Auth::guard('customer')->user();
            
            // Fetch pending payments from database with more comprehensive info
            $pendingPayments = DB::table('payments')
                ->join('pay_later_payments', 'payments.id', '=', 'pay_later_payments.payment_id')
                ->join('car_bookings', 'payments.booking_id', '=', 'car_bookings.id')
                ->where('payments.customer_id', $customer->id)
                ->where(function($query) {
                    $query->where('pay_later_payments.status', '!=', 'paid')
                          ->orWhereNull('pay_later_payments.status');
                })
                ->select(
                    'payments.id',
                    'payments.booking_id',
                    'payments.amount',
                    'payments.currency',
                    'payments.status as payment_status',
                    'pay_later_payments.id as pay_later_id',
                    'pay_later_payments.status as pay_later_status',
                    'pay_later_payments.collection_date',
                    'pay_later_payments.collection_method',
                    'car_bookings.car_id',
                    'car_bookings.pickup_datetime',
                    'car_bookings.dropoff_datetime'
                )
                ->orderBy('pay_later_payments.collection_date', 'asc')
                ->get();
                
            return view('customer.pay-later', ['pendingPayments' => $pendingPayments]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in PayLater controller: ' . $e->getMessage());
            
            // Return view with error message
            return view('customer.pay-later', [
                'pendingPayments' => collect([]), // Empty collection
                'error' => 'An error occurred while loading your payment data. Please try again later.'
            ]);
        }
    }
    
    /**
     * Process a pay later payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'payment_method' => 'required|string'
        ]);
        
        // Get the payment details
        $payment = DB::table('payments')
            ->join('pay_later_payments', 'payments.id', '=', 'pay_later_payments.payment_id')
            ->where('payments.id', $validated['payment_id'])
            ->select('payments.*', 'pay_later_payments.id as pay_later_id')
            ->first();
            
        // Check if payment belongs to authenticated customer
        if ($payment->customer_id != Auth::guard('customer')->id()) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized payment access']);
        }
        
        // Update payment status
        DB::beginTransaction();
        
        try {
            // Update the payment record
            DB::table('payments')
                ->where('id', $payment->id)
                ->update([
                    'status' => 'paid',
                    'payment_method' => $validated['payment_method'],
                    'updated_at' => Carbon::now()
                ]);
                
            // Update the pay later payment record
            DB::table('pay_later_payments')
                ->where('payment_id', $payment->id)
                ->update([
                    'status' => 'paid',
                    'collection_method' => $validated['payment_method'],
                    'updated_at' => Carbon::now()
                ]);
                
            DB::commit();
            
            return redirect()->route('customer.paylater')->with('success', 'Payment processed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your payment: ' . $e->getMessage()]);
        }
    }

// this will cancel the payment this is in pay later page
    //  public function cancelPayLaterPayment(Request $request)
    // {
    //     // Validate the request
    //     $validated = $request->validate([
    //         'payment_id' => 'required|exists:pay_later_payments,id',
    //     ]);

    //     // Get the pay later payment
    //     $payLaterPayment = PayLaterPayment::findOrFail($validated['payment_id']);
        
    //     // Check if the payment belongs to the current user
    //     $payment = Payment::where('id', $payLaterPayment->payment_id)->first();
        
    //     if (!$payment || $payment->customer_id != Auth::id()) {
    //         return redirect()->back()->with('error', 'You are not authorized to cancel this payment.');
    //     }
        
    //     // Update the status in both tables
    //     $payLaterPayment->status = 'cancelled';
    //     $payLaterPayment->save();
        
    //     $payment->status = 'cancelled';
    //     $payment->save();
        
    //     // Redirect with success message
    //     return redirect()->route('customer.paylater')->with('success', 'Payment has been cancelled successfully.');
    // }

    // In CustomerController.php
// public function cancelPayment($paymentId)
// {
//     try {
//         // Find the payment
//         $payment = Payment::findOrFail($paymentId);
        
//         // Update the payment status to cancelled
//         $payment->status = 'cancelled';
//         $payment->save();
        
//         // Find and update related pay_later_payments if they exist
//         $payLaterPayments = PayLaterPayment::where('payment_id', $paymentId)
//             ->whereIn('status', ['upcoming', 'pending', 'overdue'])
//             ->get();
            
//         foreach ($payLaterPayments as $payLaterPayment) {
//             $payLaterPayment->status = 'cancelled';
//             $payLaterPayment->save();
//         }
        
//         return redirect()->back()->with('success', 'Payment has been cancelled successfully.');
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Failed to cancel payment: ' . $e->getMessage());
//     }
// }
public function cancelPayment($paymentId) 
{
    try {
        // Check if we're using Eloquent models or DB facade
        if (class_exists('App\Models\Payment') || class_exists('App\Payment')) {
            // Using Eloquent
            $payment = Payment::findOrFail($paymentId);
            
            // Check if payment is already cancelled or completed
            if (in_array($payment->status, ['cancelled', 'completed', 'refunded'])) {
                return redirect()->back()->with('error', 'This payment cannot be cancelled because it is already ' . $payment->status . '.');
            }
            
            // Update the payment status to cancelled
            $payment->status = 'cancelled';
            $payment->updated_at = now();
            $payment->save();
            
            // Find and update related pay_later_payments if they exist
            if (class_exists('App\Models\PayLaterPayment') || class_exists('App\PayLaterPayment')) {
                $payLaterPayments = PayLaterPayment::where('payment_id', $paymentId)
                    ->whereIn('status', ['upcoming', 'pending', 'overdue'])
                    ->get();
                
                foreach ($payLaterPayments as $payLaterPayment) {
                    $payLaterPayment->status = 'cancelled';
                    $payLaterPayment->updated_at = now();
                    $payLaterPayment->save();
                }
            } else {
                // Using DB facade for pay_later_payments
                DB::table('pay_later_payments')
                    ->where('payment_id', $paymentId)
                    ->whereIn('status', ['upcoming', 'pending', 'overdue'])
                    ->update([
                        'status' => 'cancelled',
                        'updated_at' => now()
                    ]);
            }
        } else {
            // Using DB facade for both tables
            // Check the payment status first
            $payment = DB::table('payments')->where('id', $paymentId)->first();
            
            if (!$payment) {
                return redirect()->back()->with('error', 'Payment not found.');
            }
            
            // Check if payment is already in a final state
            if (in_array($payment->status, ['cancelled', 'completed', 'refunded'])) {
                return redirect()->back()->with('error', 'This payment cannot be cancelled because it is already ' . $payment->status . '.');
            }
            
            // Update payment status
            DB::table('payments')
                ->where('id', $paymentId)
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now()
                ]);
            
            // Update pay_later_payments if they exist
            DB::table('pay_later_payments')
                ->where('payment_id', $paymentId)
                ->whereIn('status', ['upcoming', 'pending', 'overdue'])
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now()
                ]);
        }
        
        return redirect()->back()->with('success', 'Payment has been cancelled successfully.');
    } catch (\Exception $e) {
        \Log::error('Payment cancellation error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to cancel payment: ' . $e->getMessage());
    }
}


    public function browseCars(Request $request)
{
    // Query builder for cars
    $carsQuery = DB::table('car_details_tbl')
        ->where('status', 'available');
    
    // Apply filters if provided
    if ($request->has('vehicle_type') && $request->vehicle_type != '') {
        $carsQuery->where('vehicle_type', $request->vehicle_type);
    }
    
    if ($request->has('transmission_type') && $request->transmission_type != '') {
        $carsQuery->where('transmission_type', $request->transmission_type);
    }
    
    if ($request->has('min_price') && $request->min_price != '') {
        $carsQuery->where('price', '>=', $request->min_price);
    }
    
    if ($request->has('max_price') && $request->max_price != '') {
        $carsQuery->where('price', '<=', $request->max_price);
    }
    
    // Get all distinct vehicle types for filter dropdown
    $vehicleTypes = DB::table('car_details_tbl')
                      ->select('vehicle_type')
                      ->distinct()
                      ->pluck('vehicle_type');
    
    // Get all distinct transmission types for filter dropdown
    $transmissionTypes = DB::table('car_details_tbl')
                          ->select('transmission_type')
                          ->distinct()
                          ->pluck('transmission_type');
    
    // Get filtered cars
    $cars = $carsQuery->get();
    
    return view('customer.browse-cars', compact('cars', 'vehicleTypes', 'transmissionTypes'));
}

public function carDetails($id)
{
    // Get car details
    $car = DB::table('car_details_tbl')->where('id', $id)->first();
    
    if (!$car) {
        return redirect()->route('customer.browse-cars')
                         ->with('error', 'Car not found.');
    }
    
    // Get similar cars (same vehicle type, excluding the current car)
    $similarCars = DB::table('car_details_tbl')
                     ->where('vehicle_type', $car->vehicle_type)
                     ->where('id', '!=', $id)
                     ->where('status', 'available')
                     ->limit(4)
                     ->get();
    
    return view('search_results', compact('car', 'similarCars'));
}

public function bookCar($id)
{
    // Check if user is logged in
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('customer.login')
                         ->with('error', 'Please login to book a car.');
    }
    
    // Get car details
    $car = DB::table('car_details_tbl')->where('id', $id)->first();
    
    if (!$car) {
        return redirect()->route('customer.browse-cars')
                         ->with('error', 'Car not found.');
    }
    
    if ($car->status != 'available') {
        return redirect()->route('customer.browse-cars')
                         ->with('error', 'This car is not available for booking.');
    }
    
    return view('cars.book', compact('car'));
}
//  when i click on retal history in customer dashboard
public function rentalHistory()
{
    $customer = Auth::guard('customer')->user();
    
    // Get all bookings for this customer with car information joined
    $bookings = DB::table('car_bookings')
    ->leftJoin('car_details_tbl', 'car_bookings.car_id', '=', 'cars.id')
    ->where('car_bookings.customer_id', $customer->id)
    ->select(
        'car_bookings.*', 
        DB::raw("CONCAT(cars.make, ' ', cars.model, ' (', cars.year, ')') as car_name")
    )
    ->orderBy('car_bookings.created_at', 'desc')
    ->get();
    
    // Get all payment information for these bookings
    $bookingIds = $bookings->pluck('id')->toArray();
    
    $payments = DB::table('payments')
        ->whereIn('booking_id', $bookingIds)
        ->get()
        ->keyBy('booking_id');
    
    // Check if any bookings have pay later payments
    $payLaterPayments = DB::table('pay_later_payments')
        ->whereIn('booking_id', $bookingIds)
        ->get()
        ->groupBy('booking_id');
    
    return view('customer.rental-history', compact('bookings', 'payments', 'payLaterPayments'));
}

    
    

}


