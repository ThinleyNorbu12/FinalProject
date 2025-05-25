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
use App\Models\CarDetail;
use App\Models\AdminCar;

use App\Models\PayLaterPayment;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // Show dashboard
    // public function dashboard()
    // {
    //     return view('customer.dashboard');
    // }

//    public function dashboard()
//     {
//         $userId = Auth::id();

//         // Get the most recent active booking for the logged-in user
//         $booking = CarBooking::where('customer_id', $userId)
//                     ->where('status', 'active') // Assuming 'active' status indicates a current rental
//                     ->latest('pickup_datetime') // ✅ use correct column
//                     ->first();

//         // Get the car details if a booking exists
//         $car = $booking ? Car::find($booking->car_id) : null;

//         return view('customer.dashboard', compact('booking', 'car'));
//     }

public function dashboard()
{
    $userId = Auth::id();

    // Get the most recent active booking for the logged-in user
    $booking = CarBooking::where('customer_id', $userId)
                ->where('status', 'active')
                ->latest('pickup_datetime')
                ->first();

    // Get the car details if a booking exists
    $car = $booking ? Car::find($booking->car_id) : null;

    // Get recommended available cars (from car_details_tbl)
    $recommendedCars = CarDetail::where('status', 'available')
                        ->orderBy('created_at', 'desc')
                        ->take(6) // Get 6 recommended cars
                        ->get();

    return view('customer.dashboard', compact('booking', 'car', 'recommendedCars'));
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

    // public function payLater()
    // {
    //     try {
    //         // Get the authenticated customer
    //         $customer = Auth::guard('customer')->user();
            
    //         // Fetch pending payments from database with more comprehensive info
    //         $pendingPayments = DB::table('payments')
    //             ->join('pay_later_payments', 'payments.id', '=', 'pay_later_payments.payment_id')
    //             ->join('car_bookings', 'payments.booking_id', '=', 'car_bookings.id')
    //             ->where('payments.customer_id', $customer->id)
    //             ->where(function($query) {
    //                 $query->where('pay_later_payments.status', '!=', 'paid')
    //                       ->orWhereNull('pay_later_payments.status');
    //             })
    //             ->select(
    //                 'payments.id',
    //                 'payments.booking_id',
    //                 'payments.amount',
    //                 'payments.currency',
    //                 'payments.status as payment_status',
    //                 'pay_later_payments.id as pay_later_id',
    //                 'pay_later_payments.status as pay_later_status',
    //                 'pay_later_payments.collection_date',
    //                 'pay_later_payments.collection_method',
    //                 'car_bookings.car_id',
    //                 'car_bookings.pickup_datetime',
    //                 'car_bookings.dropoff_datetime'
    //             )
    //             ->orderBy('pay_later_payments.collection_date', 'asc')
    //             ->get();
                
    //         return view('customer.pay-later', ['pendingPayments' => $pendingPayments]);
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Error in PayLater controller: ' . $e->getMessage());
            
    //         // Return view with error message
    //         return view('customer.pay-later', [
    //             'pendingPayments' => collect([]), // Empty collection
    //             'error' => 'An error occurred while loading your payment data. Please try again later.'
    //         ]);
    //     }
    // }

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
    
    public function processPayment(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'payment_method' => 'required|string',
            'bank_code' => 'nullable|string',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Make screenshot required for QR code payments
        ]);

        // Get the payment details
        $payment = DB::table('payments')
            ->where('payments.id', $validated['payment_id'])
            ->first();

        // Get the pay later payment record
        $payLaterPayment = DB::table('pay_later_payments')
            ->where('payment_id', $validated['payment_id'])
            ->first();

        // Check if payment exists
        if (!$payment || !$payLaterPayment) {
            return redirect()->back()->withErrors(['error' => 'Payment not found']);
        }

        // Check if payment belongs to authenticated customer
        if ($payment->customer_id != Auth::guard('customer')->id()) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized payment access']);
        }

        // Handle screenshot upload
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshot = $request->file('screenshot');
            $screenshotName = 'payment_' . $payment->id . '_' . time() . '.' . $screenshot->getClientOriginalExtension();
            
            // Create the qr_payments directory if it doesn't exist
            $uploadPath = public_path('uploads/qr_payments');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move the file to the specified directory
            $screenshot->move($uploadPath, $screenshotName);
            $screenshotPath = 'uploads/qr_payments/' . $screenshotName;
        }

        // Update payment status
        DB::beginTransaction();

        try {
            // Update the payment record in payments table
            DB::table('payments')
                ->where('id', $payment->id)
                ->update([
                    'status' => 'completed', // Set status to completed
                    'payment_method' => $validated['payment_method'],
                    'payment_date' => Carbon::now(),
                    'reference_number' => 'QR' . time() . rand(1000, 9999), // Generate a reference number
                    'updated_at' => Carbon::now()
                ]);

            // Update the pay_later_payments record
            $updateData = [
                'status' => 'paid',
                'collection_date' => Carbon::now(),
                'collection_method' => $validated['payment_method'],
                'notes' => 'Paid via ' . $validated['payment_method'] . ' on ' . Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()
            ];

            // Store bank code if provided
            if (!empty($validated['bank_code'])) {
                // Check if bank_code column exists in the table
                if (DB::getSchemaBuilder()->hasColumn('pay_later_payments', 'bank_code')) {
                    $updateData['bank_code'] = $validated['bank_code'];
                }
            }

            // Store screenshot path if screenshot was uploaded
            if ($screenshotPath) {
                // Check if screenshot_path column exists in the table
                if (DB::getSchemaBuilder()->hasColumn('pay_later_payments', 'screenshot_path')) {
                    $updateData['screenshot_path'] = $screenshotPath;
                } else {
                    // Add screenshot info to notes if column doesn't exist
                    $updateData['notes'] = $updateData['notes'] . ' (Screenshot uploaded)';
                }
            }

            DB::table('pay_later_payments')
                ->where('payment_id', $payment->id)
                ->update($updateData);

            DB::commit();

            return redirect()->route('customer.paylater')->with('success', 'Payment completed successfully! Your payment has been recorded.');
        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if transaction fails
            if ($screenshotPath && file_exists(public_path($screenshotPath))) {
                unlink(public_path($screenshotPath));
            }
            
            // Log the error for debugging
            \Log::error('Payment processing error: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your payment. Please try again.']);
        }
    }

//     public function processPayment(Request $request)
// {
//     // Validate the request
//     $validated = $request->validate([
//         'payment_id' => 'required|exists:payments,id',
//         'payment_method' => 'required|string',
//         'bank_code' => 'nullable|string',
//         'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     // Get the payment details
//     $payment = DB::table('payments')->where('id', $validated['payment_id'])->first();
//     $payLaterPayment = DB::table('pay_later_payments')->where('payment_id', $validated['payment_id'])->first();

//     // Check if payment and record exist
//     if (!$payment || !$payLaterPayment) {
//         return redirect()->back()->withErrors(['error' => 'Payment not found']);
//     }

//     // Check if payment belongs to the authenticated customer
//     if ($payment->customer_id != Auth::guard('customer')->id()) {
//         return redirect()->back()->withErrors(['error' => 'Unauthorized payment access']);
//     }

//     // Handle screenshot upload
//     $screenshotPath = null;
//     if ($request->hasFile('screenshot')) {
//         $screenshot = $request->file('screenshot');
//         $screenshotName = 'payment_' . $payment->id . '_' . time() . '.' . $screenshot->getClientOriginalExtension();

//         $uploadPath = public_path('pay_later_payments');
//         if (!file_exists($uploadPath)) {
//             mkdir($uploadPath, 0755, true);
//         }

//         $screenshot->move($uploadPath, $screenshotName);
//         $screenshotPath = 'pay_later_payments/' . $screenshotName;
//     }

//     // Begin transaction
//     DB::beginTransaction();

//     try {
//         // Update payments table
//         DB::table('payments')->where('id', $payment->id)->update([
//             'status' => 'completed',
//             'payment_method' => $validated['payment_method'],
//             'payment_date' => Carbon::now(),
//             'reference_number' => 'QR' . time() . rand(1000, 9999),
//             'updated_at' => Carbon::now()
//         ]);

//         // Prepare update data
//         $updateData = [
//             'status' => 'paid',
//             'collection_date' => Carbon::now(),
//             'collection_method' => $validated['payment_method'],
//             'notes' => 'Paid via ' . $validated['payment_method'] . ' on ' . Carbon::now()->format('Y-m-d H:i:s'),
//             'updated_at' => Carbon::now()
//         ];

//         if (!empty($validated['bank_code']) && DB::getSchemaBuilder()->hasColumn('pay_later_payments', 'bank_code')) {
//             $updateData['bank_code'] = $validated['bank_code'];
//         }

//         if ($screenshotPath && DB::getSchemaBuilder()->hasColumn('pay_later_payments', 'screenshot_image_path')) {
//             $updateData['screenshot_image_path'] = $screenshotPath;
//         } elseif ($screenshotPath) {
//             $updateData['notes'] .= ' (Screenshot uploaded)';
//         }

//         // Update pay_later_payments table
//         DB::table('pay_later_payments')->where('payment_id', $payment->id)->update($updateData);

//         DB::commit();

//         return redirect()->route('customer.paylater')->with('success', 'Payment completed successfully! Your payment has been recorded.');

//     } catch (\Exception $e) {
//         DB::rollBack();

//         if ($screenshotPath && file_exists(public_path($screenshotPath))) {
//             unlink(public_path($screenshotPath));
//         }

//         \Log::error('Payment processing error: ' . $e->getMessage());

//         return redirect()->back()->withErrors(['error' => 'An error occurred while processing your payment. Please try again.']);
//     }
// }



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


//     public function browseCars(Request $request)
// {
//     // Query builder for cars
//     $carsQuery = DB::table('car_details_tbl')
//         ->where('status', 'available');
    
//     // Apply filters if provided
//     if ($request->has('vehicle_type') && $request->vehicle_type != '') {
//         $carsQuery->where('vehicle_type', $request->vehicle_type);
//     }
    
//     if ($request->has('transmission_type') && $request->transmission_type != '') {
//         $carsQuery->where('transmission_type', $request->transmission_type);
//     }
    
//     if ($request->has('min_price') && $request->min_price != '') {
//         $carsQuery->where('price', '>=', $request->min_price);
//     }
    
//     if ($request->has('max_price') && $request->max_price != '') {
//         $carsQuery->where('price', '<=', $request->max_price);
//     }
    
//     // Get all distinct vehicle types for filter dropdown
//     $vehicleTypes = DB::table('car_details_tbl')
//                       ->select('vehicle_type')
//                       ->distinct()
//                       ->pluck('vehicle_type');
    
//     // Get all distinct transmission types for filter dropdown
//     $transmissionTypes = DB::table('car_details_tbl')
//                           ->select('transmission_type')
//                           ->distinct()
//                           ->pluck('transmission_type');
    
//     // Get filtered cars
//     $cars = $carsQuery->get();
    
//     return view('customer.browse-cars', compact('cars', 'vehicleTypes', 'transmissionTypes'));
// }

public function browseCars(Request $request)
{
    // Filters
    $vehicleType = $request->vehicle_type;
    $transmissionType = $request->transmission_type;
    $minPrice = $request->min_price;
    $maxPrice = $request->max_price;

    // Base queries for both tables
    $adminCarsQuery = DB::table('admin_cars_tbl')->where('status', 'available');
    $carDetailsQuery = DB::table('car_details_tbl')->where('status', 'available');

    // Apply filters to both queries
    foreach ([$adminCarsQuery, $carDetailsQuery] as $query) {
        if (!empty($vehicleType)) {
            $query->where('vehicle_type', $vehicleType);
        }
        if (!empty($transmissionType)) {
            $query->where('transmission_type', $transmissionType);
        }
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
    }

    // Execute both queries
    $adminCars = $adminCarsQuery->get();
    $carDetails = $carDetailsQuery->get();

    // Merge both results
    $cars = $adminCars->merge($carDetails);

    // Get distinct vehicle types and transmission types from both tables
    $vehicleTypes = DB::table('admin_cars_tbl')->select('vehicle_type')->distinct()
        ->union(
            DB::table('car_details_tbl')->select('vehicle_type')->distinct()
        )->pluck('vehicle_type')->unique()->sort()->values();

    $transmissionTypes = DB::table('admin_cars_tbl')->select('transmission_type')->distinct()
        ->union(
            DB::table('car_details_tbl')->select('transmission_type')->distinct()
        )->pluck('transmission_type')->unique()->sort()->values();

    return view('customer.browse-cars', compact('cars', 'vehicleTypes', 'transmissionTypes'));
}

// public function carDetails($id)
// {
//     // Get car details
//     $car = DB::table('car_details_tbl')->where('id', $id)->first();
    
//     if (!$car) {
//         return redirect()->route('customer.browse-cars')
//                          ->with('error', 'Car not found.');
//     }
    
//     // Get similar cars (same vehicle type, excluding the current car)
//     $similarCars = DB::table('car_details_tbl')
//                      ->where('vehicle_type', $car->vehicle_type)
//                      ->where('id', '!=', $id)
//                      ->where('status', 'available')
//                      ->limit(4)
//                      ->get();
    
//     return view('search_results', compact('car', 'similarCars'));
// }

public function carDetails($id)
{
    // Try to get the car from car_details_tbl first
    $car = DB::table('car_details_tbl')->where('id', $id)->first();

    // If not found in car_details_tbl, try admin_cars_tbl
    if (!$car) {
        $car = DB::table('admin_cars_tbl')->where('id', $id)->first();
        $sourceTable = 'admin_cars_tbl';
    } else {
        $sourceTable = 'car_details_tbl';
    }

    // If still not found, redirect with error
    if (!$car) {
        return redirect()->route('customer.browse-cars')
                         ->with('error', 'Car not found.');
    }

    // Get similar cars (from both tables), same vehicle_type, excluding current car
    $similarFromOwners = DB::table('car_details_tbl')
                        ->where('vehicle_type', $car->vehicle_type)
                        ->where('id', '!=', $car->id)
                        ->where('status', 'available')
                        ->get();

    $similarFromAdmins = DB::table('admin_cars_tbl')
                        ->where('vehicle_type', $car->vehicle_type)
                        ->where('id', '!=', $car->id)
                        ->where('status', 'available')
                        ->get();

    // Merge and limit to 4 similar cars
    $similarCars = $similarFromOwners->merge($similarFromAdmins)->take(4);

    return view('customer.cardetails', compact('car', 'similarCars'));
}


// public function bookCar($id)
// {
//     // Check if user is logged in
//     if (!Auth::guard('customer')->check()) {
//         return redirect()->route('customer.login')
//                          ->with('error', 'Please login to book a car.');
//     }
    
//     // Get car details
//     $car = DB::table('car_details_tbl')->where('id', $id)->first();
    
//     if (!$car) {
//         return redirect()->route('customer.browse-cars')
//                          ->with('error', 'Car not found.');
//     }
    
//     if ($car->status != 'available') {
//         return redirect()->route('customer.browse-cars')
//                          ->with('error', 'This car is not available for booking.');
//     }
    
//     return view('cars.book', compact('car'));
// }

public function bookCar($id)
{
    // Check if user is logged in
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('customer.login')
                         ->with('error', 'Please login to book a car.');
    }
    
    // Get car details using Eloquent model with images relationship
    $car = CarDetail::with('images')->where('id', $id)->first();
    
    // Alternative: If you want to load images conditionally
    // $car = CarDetail::find($id);
    // if ($car) {
    //     $car->load('images');
    // }
    
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
public function rentalHistory() {
    $customer = Auth::guard('customer')->user();
    
    // Get all bookings for this customer with car information joined
    $bookings = DB::table('car_bookings')
        ->leftJoin('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
        ->where('car_bookings.customer_id', $customer->id)
        ->select(
            'car_bookings.*',
            DB::raw("CONCAT(car_details_tbl.maker, ' ', car_details_tbl.model) as car_name"),
            'car_details_tbl.car_image' // Add this line to fetch the car image
        )
        ->orderBy('car_bookings.created_at', 'desc')
        ->get();
    
    // Rest of your code remains the same...
    $bookingIds = $bookings->pluck('id')->toArray();
    
    $payments = DB::table('payments')
        ->whereIn('booking_id', $bookingIds)
        ->get()
        ->keyBy('booking_id');
    
    $payLaterPayments = DB::table('pay_later_payments')
        ->whereIn('booking_id', $bookingIds)
        ->get()
        ->groupBy('booking_id');
    
    return view('customer.rental-history', compact('bookings', 'payments', 'payLaterPayments'));
}
    

public function paymentHistory()
{
    $customerId = Auth::guard('customer')->id();
    
    // Get all payments for this customer
    $payments = DB::table('payments')
        ->where('customer_id', $customerId)
        ->orderBy('payment_date', 'desc')
        ->get();
    
    // Fetch related booking IDs to join with other tables
    $bookingIds = $payments->pluck('booking_id')->toArray();
    
    // Get all pay later payments related to this customer's bookings
    $payLaterPayments = DB::table('pay_later_payments')
        ->whereIn('booking_id', $bookingIds)
        ->get()
        ->keyBy('payment_id');
    
    // Get all QR payments related to this customer's payments
    $qrPayments = DB::table('qr_payments')
        ->whereIn('payment_id', $payments->pluck('id')->toArray())
        ->get()
        ->keyBy('payment_id');
    
    // Combine the data for the view
    $paymentData = $payments->map(function($payment) use ($payLaterPayments, $qrPayments) {
        $data = (array) $payment;
        
        // Add pay later payment details if exists
        if (isset($payLaterPayments[$payment->id])) {
            $data['pay_later'] = $payLaterPayments[$payment->id];
        }
        
        // Add QR payment details if exists
        if (isset($qrPayments[$payment->id])) {
            $data['qr_payment'] = $qrPayments[$payment->id];
        }
        
        return $data;
    });
    
    return view('customer.payment-history', compact('paymentData'));
}


public function myReservations()
{
    $customer = Auth::guard('customer')->user();
    
    if (!$customer) {
        return redirect()->route('customer.login')->with('error', 'Please login to view your reservations');
    }

    // Get all bookings for this customer with related car information
    $bookings = \App\Models\CarBooking::with(['car', 'payments', 'payLaterPayments'])
        ->where('customer_id', $customer->id)
        ->orderBy('pickup_datetime', 'desc')
        ->get();
    
    // Categorize bookings
    $activeBookings = $bookings->filter(function($booking) {
        return in_array($booking->status, ['active', 'confirmed', 'pending']);
    });
    
    $completedBookings = $bookings->filter(function($booking) {
        return $booking->status === 'completed';
    });
    
    $cancelledBookings = $bookings->filter(function($booking) {
        return $booking->status === 'cancelled';
    });
    
    return view('customer.my-reservations', compact('activeBookings', 'completedBookings', 'cancelledBookings'));
}

/**
 * Show reservation details.
 *
 * @param int $id
 * @return \Illuminate\View\View
 */
public function reservationDetails($id) {
    $customer = Auth::guard('customer')->user();
    
    if (!$customer) {
        return redirect()->route('customer.login')->with('error', 'Please login to view reservation details');
    }
    
    $booking = \App\Models\CarBooking::with(['car', 'payments', 'payLaterPayments', 'payments.qrPayment'])
        ->where('id', $id)
        ->where('customer_id', $customer->id)
        ->firstOrFail();
    
    // Fetch the license information for this customer
    $license = \App\Models\DrivingLicense::where('customer_id', $customer->id)->first();
    
    // If no license found, create an empty object to avoid undefined variable errors
    if (!$license) {
        $license = new \stdClass();
    }
    
    // Get similar cars - use vehicle_type instead of category
    $similarCars = [];
    if ($booking->car) {
        $similarCars = \App\Models\CarDetail::where('vehicle_type', $booking->car->vehicle_type)
            ->where('id', '!=', $booking->car->id)
            ->take(3)
            ->get();
    }
    
    return view('customer.reservation-details', compact('booking', 'license', 'similarCars'));
}
/**
 * Cancel a reservation.
 *
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function cancelReservation($id)
{
    $customer = Auth::guard('customer')->user();
    
    if (!$customer) {
        return redirect()->route('customer.login')->with('error', 'Please login to cancel your reservation');
    }
    
    $booking = \App\Models\CarBooking::where('id', $id)
        ->where('customer_id', $customer->id)
        ->where('status', '!=', 'completed')
        ->where('status', '!=', 'cancelled')
        ->firstOrFail();
    
    // Check if cancellation is allowed (e.g., not too close to pickup time)
    $pickupTime = new \DateTime($booking->pickup_datetime);
    $now = new \DateTime();
    $hoursUntilPickup = ($pickupTime->getTimestamp() - $now->getTimestamp()) / 3600;
    
    if ($hoursUntilPickup < 24) {
        return redirect()->back()->with('error', 'Reservations cannot be cancelled less than 24 hours before pickup');
    }
    
    // Update booking status
    $booking->status = 'cancelled';
    $booking->save();
    
    // Add cancellation logic here - refunds, notifications, etc.
    
    return redirect()->route('customer.my-reservations')->with('success', 'Your reservation has been cancelled');
}


    public function locations()
    {
        // You could load locations from database
        // For now we'll just return the view with the hardcoded RIM location
        
        return view('customer.locations');
    }
    
    /**
     * Submit a location contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSubmit(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would process the contact form
        // You could send an email, store in database, etc.
        
        // For now we'll just redirect with a success message
        return redirect()->route('customer.locations')
            ->with('success', 'Your message has been sent successfully. We will contact you soon.');
    }

    public function fuelPolicy()
    {
        return view('customer.fuel-policy');
    }

    public function insuranceOptions()
    {
        return view('customer.insurance-options');
    }











//     public function showCarDetails($id)
// {
//     // Try to find the car in admin_cars_tbl first
//     $car = DB::table('admin_cars_tbl')->where('id', $id)->first();
    
//     // If not found, try car_details_tbl
//     if (!$car) {
//         $car = DB::table('car_details_tbl')->where('id', $id)->first();
//     }
    
//     // If still not found, return 404
//     if (!$car) {
//         abort(404, 'Car not found');
//     }
    
//     return view('customer.cardetails', compact('car'));
// }



public function showCarDetailsWithModels($id)
{
    // Try admin cars first
    $car = AdminCar::find($id);
    
    // If not found, try car details
    if (!$car) {
        $car = CarDetail::find($id);
    }
    
    if (!$car) {
        abort(404, 'Car not found');
    }
    
    return view('customer.cardetails', compact('car'));
}

// If you want to search both tables and indicate the source:

public function showCarDetailsWithSource($id)
{
    $car = null;
    $source = null;
    
    // Check admin_cars_tbl first
    $adminCar = DB::table('admin_cars_tbl')->where('id', $id)->first();
    if ($adminCar) {
        $car = $adminCar;
        $source = 'admin';
    } else {
        // Check car_details_tbl
        $carDetail = DB::table('car_details_tbl')->where('id', $id)->first();
        if ($carDetail) {
            $car = $carDetail;
            $source = 'owner';
        }
    }
    
    if (!$car) {
        abort(404, 'Car not found');
    }
    
    return view('customer.cardetails', compact('car', 'source'));
}


    

}


