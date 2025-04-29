<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarDetail;
use App\Models\CarBooking;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Submit a new booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255', 
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after:pickup_date',
        ]);
        
        // Find the car
        $car = CarDetail::findOrFail($id);
        
        // Check if car is available for the selected dates
        $isAvailable = $this->checkAvailability($id, $validated['pickup_date'], $validated['return_date']);
        
        if (!$isAvailable) {
            return back()->with('error', 'Sorry, this car is not available for the selected dates.');
        }
        
        // Create a new booking
        $booking = new CarBooking();
        $booking->car_id = $id;
        $booking->customer_name = $validated['name'];
        $booking->customer_email = $validated['email'];
        $booking->pickup_date = $validated['pickup_date'];
        $booking->dropoff_date = $validated['return_date'];
        // Add other booking details as needed
        $booking->save();
        
        // Redirect with success message
        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Your booking has been confirmed!');
    }
    
    /**
     * Check if the car is available for the selected dates
     *
     * @param  int  $carId
     * @param  string  $pickupDate
     * @param  string  $returnDate
     * @return bool
     */
    private function checkAvailability($carId, $pickupDate, $returnDate)
    {
        // Convert dates to Carbon instances
        $pickupDate = Carbon::parse($pickupDate);
        $returnDate = Carbon::parse($returnDate);
        
        // Check for conflicting bookings
        $conflictingBookings = CarBooking::where('car_id', $carId)
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                    ->orWhereBetween('dropoff_date', [$pickupDate, $returnDate])
                    ->orWhere(function ($q) use ($pickupDate, $returnDate) {
                        $q->where('pickup_date', '<=', $pickupDate)
                          ->where('dropoff_date', '>=', $returnDate);
                    });
            })
            ->count();
        
        return $conflictingBookings === 0;
    }
    
    /**
     * Display booking confirmation
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        $booking = CarBooking::with('car')->findOrFail($id);
        return view('booking.confirmation', compact('booking'));
    }
}