<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\CarBooking; // Make sure this model exists
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Session;

// class BookingController extends Controller
// {
//     // Submit booking form
//     public function submit(Request $request, $carId)
//     {
//         // Check if user is logged in
//         if (!Auth::guard('customer')->check()) {
//             // Store booking data in session to retrieve after login
//             Session::put('booking_data', [
//                 'car_id' => $carId,
//                 'pickup_date' => $request->pickup_date,
//                 'return_date' => $request->return_date,
//                 'pickup_location' => $request->pickup_location,
//                 'drop_location' => $request->drop_location
//             ]);
            
//             // Redirect to customer login with intended URL
//             return redirect()->route('customer.login')
//                 ->with('message', 'Please log in to complete your booking.');
//         }

//         // Validate form inputs
//         $request->validate([
//             'pickup_date' => 'required|date',
//             'return_date' => 'required|date|after_or_equal:pickup_date',
//             'pickup_location' => 'required|string|max:255',
//             'drop_location' => 'required|string|max:255',
//         ]);

//         // Get customer ID
//         $customerId = Auth::guard('customer')->id();

//         // Store booking
//         $booking = CarBooking::create([
//             'car_id' => $carId,
//             'customer_id' => $customerId, // Make sure this field exists in your table
//             'pickup_location' => $request->pickup_location,
//             'pickup_date' => $request->pickup_date,
//             'dropoff_location' => $request->drop_location,
//             'dropoff_date' => $request->return_date,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Redirect to booking summary page with success message
//         return redirect()->route('booking.summary')
//             ->with('success', 'Car booked successfully!');
//     }

//     // Booking summary view
//     public function summary()
//     {
//         // This will only be accessible if user is logged in (because of middleware)
//         $customerId = Auth::guard('customer')->id();
        
//         // Fetch latest booking by this customer
//         $booking = CarBooking::where('customer_id', $customerId)
//             ->with('car') // Assuming you have a relationship set up
//             ->latest()
//             ->first();

//         return view('booking.summary', compact('booking'));
//     }

//     /**
//      * Check if the car is available for the selected dates
//      *
//      * @param  int  $carId
//      * @param  string  $pickupDate
//      * @param  string  $returnDate
//      * @return bool
//      */
//     private function checkAvailability($carId, $pickupDate, $returnDate)
//     {
//         // Convert dates to Carbon instances
//         $pickupDate = Carbon::parse($pickupDate);
//         $returnDate = Carbon::parse($returnDate);
        
//         // Check for conflicting bookings
//         $conflictingBookings = CarBooking::where('car_id', $carId)
//             ->where(function ($query) use ($pickupDate, $returnDate) {
//                 $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
//                     ->orWhereBetween('dropoff_date', [$pickupDate, $returnDate])
//                     ->orWhere(function ($q) use ($pickupDate, $returnDate) {
//                         $q->where('pickup_date', '<=', $pickupDate)
//                           ->where('dropoff_date', '>=', $returnDate);
//                     });
//             })
//             ->count();
        
//         return $conflictingBookings === 0;
//     }

// }



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarBooking;
use App\Models\CarDetail; // Make sure to include Car model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; // Add Carbon for date handling
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // Add URL facade

class BookingController extends Controller
{
    // Submit booking form
    public function submit(Request $request, $carId)
    {
        // Check if user is logged in
        if (!Auth::guard('customer')->check()) {
            // Store booking data in session to retrieve after login
            Session::put('booking_data', [
                'car_id' => $carId,
                'pickup_date' => $request->pickup_date,
                'return_date' => $request->return_date,
                'pickup_location' => $request->pickup_location,
                'drop_location' => $request->drop_location
            ]);
            
            // Store the current URL to redirect back after login
            Session::put('url.intended', URL::previous());
            
            // Redirect to customer login with intended URL
            return redirect()->route('customer.login')
                ->with('message', 'Please log in to complete your booking.');
        }

        // Validate form inputs
        $request->validate([
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'pickup_location' => 'required|string|max:255',
            'drop_location' => 'required|string|max:255',
        ]);

        // Get customer ID (if needed and field exists)
        $customerId = Auth::guard('customer')->id();

        // Store booking
        $bookingData = [
            'car_id' => $carId,
            'pickup_location' => $request->pickup_location,
            'pickup_date' => $request->pickup_date,
            'dropoff_location' => $request->drop_location,
            'dropoff_date' => $request->return_date,
        ];
        
        // Add customer_id if table has been migrated
        if (Schema::hasColumn('car_bookings', 'customer_id')) {
            $bookingData['customer_id'] = $customerId;
        }
        
        $booking = CarBooking::create($bookingData);

        // Redirect to booking summary page with success message
        return redirect()->route('booking.summary')
            ->with('success', 'Car booked successfully!');
    }

    // Booking summary view
    public function summary()
    {
        // If customer_id column exists
        if (Schema::hasColumn('car_bookings', 'customer_id')) {
            $customerId = Auth::guard('customer')->id();
            $booking = CarBooking::where('customer_id', $customerId)
                ->with('car')
                ->latest()
                ->first();
        } else {
            // Fallback to just getting latest booking (not ideal but works until migration)
            $booking = CarBooking::with('car')->latest()->first();
        }

        return view('booking.summary', compact('booking'));
    }

    public function show($id)
    {
        $booking = Booking::with('car.images')->findOrFail($id);
        return view('booking.summary', compact('booking'));
    }

    /**
     * Check if the car is available for the selected dates
     *
     * @param  int  $carId
     * @param  string  $pickupDate
     * @param  string  $returnDate
     * @return bool
     */
    
}