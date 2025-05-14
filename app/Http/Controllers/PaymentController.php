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
use App\Models\PayLaterPayment;


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
    public function processPayLater(Request $request, $bookingId)
{
    DB::beginTransaction();
    
    try {
        // Load booking with car relationship
        $booking = CarBooking::with('car')->findOrFail($bookingId);
        
        // Calculate total price
        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
        $days = ceil($hours / 24);
        $dailyRate = $booking->car->price;
        $insuranceFee = 200;
        $serviceFee = 100;
        $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;
        
        // Create main payment record with pay_later status
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'payment_method' => 'pay_later',
            'amount' => $totalPrice,
            'currency' => 'BTN',
            'status' => 'pending',  // Will be collected at pickup
            'reference_number' => 'PAYLATER-' . uniqid(),
            'payment_date' => now(),
        ]);
        
        // Create pay later payment record
        PayLaterPayment::create([
            'payment_id' => $payment->id,
            'booking_id' => $booking->id,
            'status' => 'pending',
            'notes' => $request->has('notes') ? $request->notes : 'To be collected at pickup'
        ]);
        
        // Update booking status
        $booking->update([
            'status' => 'confirmed',  // Booking is confirmed even though payment is pending
            'payment_method' => 'pay_later'
        ]);
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Pay Later option confirmed successfully!',
            'redirect' => route('booking.summary', ['bookingId' => $bookingId])
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Pay Later Payment Error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error processing pay later option: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Mark a Pay Later payment as collected (for admin/staff use)
 * 
 * @param Request $request
 * @param int $paymentId
 * @return \Illuminate\Http\JsonResponse
 */
public function markPayLaterAsCollected(Request $request, $paymentId)
{
    DB::beginTransaction();
    
    try {
        $validator = validator($request->all(), [
            'collection_method' => 'required|in:cash,card,bank_transfer,qr_code',
            'notes' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        
        // Find the payment
        $payment = Payment::with('payLaterPayment', 'booking')->findOrFail($paymentId);
        
        // Check if it's a pay later payment
        if ($payment->payment_method !== 'pay_later') {
            return response()->json([
                'success' => false,
                'message' => 'This is not a Pay Later payment'
            ], 422);
        }
        
        // Update main payment status
        $payment->update([
            'status' => 'completed'
        ]);
        
        // Update pay later payment record - use admin name instead of ID
        $payment->payLaterPayment->update([
            'status' => 'collected',
            'collection_date' => now(),
            'collected_by_admin' => auth()->user()->name, // Use name instead of ID
            'collection_method' => $request->collection_method,
            'notes' => $request->notes
        ]);
        
        // If the booking status was pending due to payment, update it
        if ($payment->booking->status === 'pending_payment') {
            $payment->booking->update([
                'status' => 'confirmed'
            ]);
        }
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Payment successfully marked as collected',
            'payment' => $payment->load('payLaterPayment')
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Mark Pay Later As Collected Error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error marking payment as collected: ' . $e->getMessage()
        ], 500);
    }
}
}
