<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarBooking;
use App\Models\QrPayment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;


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

    // Handle QR payment submission (Improved version)
    // PaymentController.php
    public function processQrPayment(Request $request, $bookingId)
{
    DB::beginTransaction();

    try {
        $validator = validator($request->all(), [
            'bank_code' => 'required|string|max:10',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Load booking with car relationship
        $booking = CarBooking::with('car')->findOrFail($bookingId);
        
        // Calculate total price using the same logic as the view
        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
        $days = ceil($hours / 24);
        $dailyRate = $booking->car->price;
        $insuranceFee = 200;
        $serviceFee = 100;
        $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;

        // Create main payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'payment_method' => 'qr_code',
            'amount' => $totalPrice,
            'currency' => 'BTN',
            'status' => 'pending_verification',
            'reference_number' => 'QRPAY-' . uniqid(),
            'payment_date' => now(),
        ]);

        // Save screenshot to public/qr_payments
        $destinationPath = public_path('qr_payments');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename = time() . '_' . $request->file('screenshot')->getClientOriginalName();
        $request->file('screenshot')->move($destinationPath, $filename);
        $screenshotPath = 'qr_payments/' . $filename;

        // Store QR payment details
        QrPayment::create([
            'payment_id' => $payment->id,
            'bank_code' => $request->bank_code,
            'screenshot_path' => $screenshotPath,
            'verification_status' => 'pending'
        ]);

        // Update booking status
        $booking->update([
            'status' => 'pending_verification',
            'payment_method' => 'qr_code'
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted successfully!',
            'redirect' => route('booking.summary', ['bookingId' => $bookingId])
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('QR Payment Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Payment failed: ' . $e->getMessage()
        ], 500);
    }
}

        
    public function showPaymentPage($bookingId)
        {
            $booking = CarBooking::find($bookingId);

            if (!$booking) {
                return redirect()->route('home')->with('error', 'Booking not found.');
            }

            // Calculate total price (you may already have this logic somewhere else)
            $totalPrice = $booking->total_price ?? 15300.00; // Default to your example amount if not set

            return view('payment', compact('booking', 'totalPrice'));
        }



    // Handle Pay Later option
    public function processPayLater($bookingId)
    {
        $booking = CarBooking::find($bookingId);
        
        if ($booking) {
            // Update booking status to confirmed but marked as pay later
            $booking->status = 'confirmed';
            $booking->payment_method = 'pay_later';
            $booking->save();
            
            // Redirect to booking summary with success message
            return redirect()->route('booking.summary', ['bookingId' => $bookingId])
                ->with('success', 'Your booking is confirmed! You will pay at the time of pickup.');
        }
        
        return redirect()->route('booking.summary', ['bookingId' => $bookingId])
            ->with('error', 'Booking not found.');
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\CarBooking;
// use Illuminate\Support\Facades\Auth;

// class PaymentController extends Controller
// {
//     // Show the payment form
//     public function show($bookingId)
//     {
//         $booking = CarBooking::with('car')->findOrFail($bookingId);
        
//         // Only allow payment if the booking exists and is pending
//         if (!$booking || $booking->status !== 'pending') {
//             return redirect()->route('booking.summary', ['bookingId' => $bookingId])
//                 ->with('error', 'Booking not found or already confirmed.');
//         }
        
//         return view('payment', compact('booking'));
//     }
    
//     // Handle the payment submission
//     public function process(Request $request, $bookingId)
//     {
//         // Validate payment details
//         $request->validate([
//             'transaction_id' => 'required|string|max:100',
//             'payment_date' => 'required|date',
//             'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
//             'terms' => 'required|accepted',
//         ]);

//         $booking = CarBooking::find($bookingId);
        
//         if ($booking) {
//             // Store the payment proof
//             $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
//             // Update booking status to pending verification after payment proof submission
//             $booking->status = 'pending_verification';
//             $booking->payment_method = 'bank_transfer';
//             $booking->payment_date = $request->payment_date;
//             $booking->transaction_id = $request->transaction_id;
//             $booking->payment_proof = $path;
//             $booking->save();
            
//             // Redirect to booking summary with success message
//             return redirect()->route('booking.summary', ['bookingId' => $bookingId])
//                 ->with('success', 'Payment proof submitted successfully! Your booking is awaiting verification.');
//         }
        
//         return redirect()->route('booking.summary', ['bookingId' => $bookingId])
//             ->with('error', 'Booking not found.');
//     }
// }