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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
   public function submit(Request $request, $carId)
{
    $validated = $request->validate([
        'pickup_date' => 'required|date|after_or_equal:today',
        'pickup_time' => 'required|date_format:H:i',
        'return_date' => 'required|date|after_or_equal:pickup_date',
        'return_time' => [
            'required',
            'date_format:H:i',
            function ($attribute, $value, $fail) use ($request) {
                $pickup = Carbon::parse($request->pickup_date.' '.$request->pickup_time);
                $dropoff = Carbon::parse($request->return_date.' '.$value);
                
                if ($dropoff->lte($pickup)) {
                    $fail('Return datetime must be after pickup datetime.');
                }
            }
        ],
        'pickup_location' => 'required|string|max:255',
        'drop_location' => 'required|string|max:255',
    ]);

    // Combine date and time into datetime objects
    $pickupDatetime = Carbon::parse($validated['pickup_date'].' '.$validated['pickup_time']);
    $dropoffDatetime = Carbon::parse($validated['return_date'].' '.$validated['return_time']);

    // Check for booking conflicts
    $existingBooking = CarBooking::where('car_id', $carId)
        ->where(function($query) use ($pickupDatetime, $dropoffDatetime) {
            $query->whereBetween('pickup_datetime', [$pickupDatetime, $dropoffDatetime])
                  ->orWhereBetween('dropoff_datetime', [$pickupDatetime, $dropoffDatetime])
                  ->orWhere(function($q) use ($pickupDatetime, $dropoffDatetime) {
                      $q->where('pickup_datetime', '<=', $pickupDatetime)
                        ->where('dropoff_datetime', '>=', $dropoffDatetime);
                  });
        })
        ->whereIn('status', ['confirmed', 'pending'])
        ->exists();

    if ($existingBooking) {
        return back()->withErrors([
            'conflict' => 'This car is already booked for the selected dates.'
        ]);
    }

    $booking = CarBooking::create([
        'car_id' => $carId,
        'customer_id' => Auth::guard('customer')->id(),
        'pickup_location' => $validated['pickup_location'],
        'pickup_datetime' => $pickupDatetime,
        'dropoff_location' => $validated['drop_location'],
        'dropoff_datetime' => $dropoffDatetime,
        'status' => 'pending',
    ]);

    return redirect()->route('booking.summary', ['bookingId' => $booking->id])
           ->with('success', 'Car booked successfully!');
}

    // ✅ Summary page now expects bookingId
    public function summary($bookingId)
    {
        $booking = CarBooking::with('car')->findOrFail($bookingId);
        return view('booking.summary', compact('booking'));
    }

    public function show($id)
    {
        $booking = CarBooking::with('car.images')->findOrFail($id);
        return view('booking.summary', compact('booking'));
    }


// admin page . booked cars 
     public function index()
    {
        // Get all confirmed bookings with relationships
        $bookings = CarBooking::with(['car', 'customer', 'payment'])
            ->where('status', 'confirmed')
            ->orWhere('status', 'completed')
            ->orderBy('pickup_datetime', 'asc')
            ->get();

        // Count of bookings by status
        $statusCounts = CarBooking::select('status', DB::raw('count(*) as count'))
            ->whereIn('status', ['pending', 'confirmed', 'pending_verification', 'cancelled', 'completed'])
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.booked-car', compact('bookings', 'statusCounts'));
    }

    /**
     * Show specific booking details
     */
    public function showBookingDetails($id)
    {
        $booking = CarBooking::with(['car', 'customer', 'payment'])
            ->findOrFail($id);

        return view('admin.booking-details', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,pending_verification,cancelled,completed'
        ]);

        $booking = CarBooking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('admin.booked-car')
            ->with('success', 'Booking status updated successfully');
    }

    /**
     * Filter bookings by status
     */
    public function filter(Request $request)
    {
        $status = $request->status;
        
        $bookings = CarBooking::with(['car', 'customer', 'payment']);
        
        if ($status) {
            $bookings = $bookings->where('status', $status);
        }
        
        $bookings = $bookings->orderBy('pickup_datetime', 'asc')->get();

        // Count of bookings by status
        $statusCounts = CarBooking::select('status', DB::raw('count(*) as count'))
            ->whereIn('status', ['pending', 'confirmed', 'pending_verification', 'cancelled', 'completed'])
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.booked-car', compact('bookings', 'statusCounts'));
    }
}
