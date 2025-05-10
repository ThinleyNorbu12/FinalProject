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
            'transaction_id' => 'required|string|max:100',
            'payment_date' => 'required|date',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'terms' => 'required|accepted',
        ]);

        $booking = CarBooking::find($bookingId);
        
        if ($booking) {
            // Store the payment proof
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            // Update booking status to pending verification after payment proof submission
            $booking->status = 'pending_verification';
            $booking->payment_method = 'bank_transfer';
            $booking->payment_date = $request->payment_date;
            $booking->transaction_id = $request->transaction_id;
            $booking->payment_proof = $path;
            $booking->save();
            
            // Redirect to booking summary with success message
            return redirect()->route('booking.summary', ['bookingId' => $bookingId])
                ->with('success', 'Payment proof submitted successfully! Your booking is awaiting verification.');
        }
        
        return redirect()->route('booking.summary', ['bookingId' => $bookingId])
            ->with('error', 'Booking not found.');
    }
}