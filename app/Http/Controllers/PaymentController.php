<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\CarBooking; // Make sure this matches your model name
// use Illuminate\Support\Facades\Auth;

// class PaymentController extends Controller
// {
//     // Show the payment form
//     public function show($bookingId)
//     {
//         $booking = CarBooking::find($bookingId);

//         // Only allow payment if the booking exists and is pending
//         if (!$booking || $booking->status !== 'pending') {
//             return redirect()->route('booking.summary')->with('error', 'Booking not found or already confirmed.');
//         }

//         return view('payment', compact('booking'));
//     }

//     // Handle the payment submission
//     public function process(Request $request, $bookingId)
//     {
//         // Validate payment details
//         $request->validate([
//             'card_number' => 'required',
//             'expiry_date' => 'required',
//             'cvv' => 'required',
//         ]);

//         // Simulate payment success (add actual payment logic here)
//         $booking = CarBooking::find($bookingId);
//         if ($booking) {
//             // Update booking status to confirmed after successful payment
//             $booking->status = 'confirmed';
//             $booking->save();

//             return redirect()->route('booking.summary', ['bookingId' => $bookingId])
//             ->with('success', 'Payment successful! Your booking is confirmed.');

//         }

//         return redirect()->route('booking.summary')->with('error', 'Booking not found.');
//     }
// }



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarBooking;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show the payment form
    public function show($bookingId)
    {
        $booking = CarBooking::with('car')->findOrFail($bookingId);

        // Only allow payment if the booking exists and is pending
        if (!$booking || $booking->status !== 'pending') {
            return redirect()->route('booking.summary', ['bookingId' => $bookingId])
                ->with('error', 'Booking not found or already confirmed.');
        }

        return view('payment', compact('booking'));
    }

    // Handle the payment submission
    public function process(Request $request, $bookingId)
    {
        // Validate payment details
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal',
            'terms' => 'required|accepted',
            'card_name' => 'required_if:payment_method,credit_card',
            'card_number' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
            'address_line1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        // Simulate payment success (add actual payment logic here)
        $booking = CarBooking::find($bookingId);
        if ($booking) {
            // Update booking status to confirmed after successful payment
            $booking->status = 'confirmed';
            $booking->payment_method = $request->payment_method;
            $booking->payment_date = now();
            $booking->save();

            // Redirect to booking summary with success message
            return redirect()->route('booking.summary', ['bookingId' => $bookingId])
                ->with('success', 'Payment successful! Your booking is confirmed.');
        }

        return redirect()->route('booking.summary', ['bookingId' => $bookingId])
            ->with('error', 'Booking not found.');
    }
}