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
        
        // Calculate total price using rate_per_day instead of price
        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
        $days = ceil($hours / 24);
        $dailyRate = $booking->car->rate_per_day; // Changed from price to rate_per_day
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
            'status' => 'confirmed',
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
        
        // Calculate total price using rate_per_day instead of price
        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
        $days = ceil($hours / 24);
        $dailyRate = $booking->car->rate_per_day; // Changed from price to rate_per_day
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


// admin page payment 
     public function index()
    {
        // Get all payments with related booking and customer data
        $payments = Payment::with([
            'booking', 
            'customer', 
            'qrPayment',
            'payLaterPayment'
        ])->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.payment', compact('payments'));
        


    }

    /**
     * Show details for a specific payment
     */
    // public function showPayment($id)
    // {
    //     $payment = Payment::with([
    //         'booking', 
    //         'customer', 
    //         'qrPayment',
    //         'payLaterPayment'
    //     ])->findOrFail($id);

    //     return view('admin.paymentshow', compact('payment'));
    // }
//    public function showPayment($paymentId)
// {
//     $payment = Payment::find($paymentId);
    
//     if (!$payment) {
//         // Payment doesn't exist in the database
//         return redirect()->route('admin.payments.index')
//             ->with('error', 'Payment not found');
//     }
    
//     // Only include relationships that actually exist on the Payment model
//     $payment = Payment::with([
//         'booking', 
//         'customer', 
//         'qrPayment',
//         'payLaterPayment',
//         // Remove 'order' and its nested relationships if they don't exist
//         // 'order',
//         // 'order.items',
//         // 'order.items.product',
//         // 'bankTransfer',
//         // 'cardPayment'
//     ])->findOrFail($paymentId);
    
//     return view('admin.paymentshow', compact('payment'));
// }

public function showPayment($paymentId)
{
    // Find the payment or show a 404 error
    $payment = Payment::findOrFail($paymentId);
    
    // Load all related data
    $payment->load([
        'booking', 
        'customer', 
        'qrPayment',  // Direct relationship
        'payLaterPayment'
    ]);
    
    return view('admin.paymentshow', compact('payment'));
}


    /**
     * Update payment status
     */
    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $validatedData = $request->validate([
            'status' => 'required|in:pending,pending_verification,processing,completed,failed,refunded,cancelled',
        ]);

        $payment->status = $validatedData['status'];
        $payment->save();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment status updated successfully');
    }

    /**
     * Verify QR payment 
     */
//     public function verifyQrPayment(Request $request, $paymentId)
// {
//     // Log request at start with more details
//     \Log::debug('QR Payment verification started', [
//         'payment_id' => $paymentId,
//         'request_data' => $request->all()
//     ]);
    
//     try {
//         // Find the payment record
//         $payment = Payment::findOrFail($paymentId);
//         \Log::debug('Payment found', [
//             'payment_id' => $payment->id,
//             'payment_method' => $payment->payment_method,
//             'payment_status' => $payment->status
//         ]);
        
//         // Validate request
//         $request->validate([
//             'verification_status' => 'required|in:confirmed,rejected',
//             'admin_notes' => 'nullable|string',
//         ]);
        
//         // Get the admin user
//         $admin = Auth::guard('admin')->user();
        
//         if (!$admin) {
//             \Log::error('Admin authentication failed for payment verification');
//             return back()->with('error', 'Admin authentication failed. Please login again.');
//         }
        
//         // Log admin details
//         \Log::debug('Admin authenticated', [
//             'admin_id' => $admin->id, 
//             'admin_email' => $admin->email
//         ]);
        
//         // Check if this admin has a corresponding user record
//         $userId = DB::table('users')->where('email', $admin->email)->value('id');
        
//         if (!$userId) {
//             \Log::warning('Admin verification failed: Admin (ID: ' . $admin->id .
//                           ') tried to verify payment but has no corresponding user record');
                     
//             return back()->with('error',
//                  'Verification failed: Your admin account is not linked to a user record. Please contact the system administrator.');
//         }
        
//         // Debugging: Check if the QR payment exists
//         $qrPayment = QrPayment::where('payment_id', $payment->id)->first();
//         \Log::debug('QR Payment lookup result', [
//             'payment_id' => $payment->id,
//             'qr_payment_exists' => $qrPayment ? true : false,
//             'qr_payment_id' => $qrPayment ? $qrPayment->id : null
//         ]);
        
//         // If there's no QR payment record, create one
//         if (!$qrPayment) {
//             \Log::info('QR Payment record not found, creating new record');
//             $qrPayment = new QrPayment();
//             $qrPayment->payment_id = $payment->id;
//             $qrPayment->bank_code = 'bob'; // Set a default or pull from your form
//             $qrPayment->verification_status = 'pending';
//             $qrPayment->save();
            
//             \Log::debug('Created new QR payment record', [
//                 'qr_payment_id' => $qrPayment->id,
//                 'payment_id' => $payment->id
//             ]);
//         }
        
//         // Update the QR payment
//         $qrPayment->verification_status = $request->verification_status;
//         $qrPayment->verified_by = $userId;
//         $qrPayment->verified_at = now();
//         $qrPayment->admin_notes = $request->admin_notes;
//         $qrPayment->save();
        
//         \Log::debug('QR Payment updated', [
//             'qr_payment_id' => $qrPayment->id,
//             'new_status' => $request->verification_status
//         ]);
        
//         // Update the payment status
//         $payment->status = $request->verification_status === 'confirmed' ? 'completed' : 'failed';
//         $payment->save();
        
//         \Log::debug('Main payment record updated', [
//             'payment_id' => $payment->id,
//             'new_status' => $payment->status
//         ]);
        
//         // Log this action
//         \Log::info('Payment verification: Payment #' . $payment->id . ' marked as ' . 
//                    $request->verification_status . ' by admin #' . $admin->id . ' (user ID: ' . $userId . ')');
        
//         return redirect()->route('admin.payments.show', $payment->id)
//             ->with('success', 'Payment has been ' . ($request->verification_status === 'confirmed' ? 'confirmed' : 'rejected'));
    
//     } catch (\Exception $e) {
//         \Log::error('Exception in verifyQrPayment: ' . $e->getMessage(), [
//             'payment_id' => $paymentId,
//             'trace' => $e->getTraceAsString()
//         ]);
        
//         return back()->with('error', 'An error occurred during verification: ' . $e->getMessage());
//     }
// }
public function verifyQrPayment(Request $request, $paymentId)
{
    // Log request at start with more details
    \Log::debug('QR Payment verification started', [
        'payment_id' => $paymentId,
        'request_data' => $request->all()
    ]);
    
    try {
        // Find the payment record
        $payment = Payment::findOrFail($paymentId);
        \Log::debug('Payment found', [
            'payment_id' => $payment->id,
            'payment_method' => $payment->payment_method,
            'payment_status' => $payment->status
        ]);
        
        // Validate request
        $request->validate([
            'verification_status' => 'required|in:confirmed,rejected',
            'admin_notes' => 'nullable|string',
        ]);
        
        // Get the admin user
        $admin = Auth::guard('admin')->user();
        
        if (!$admin) {
            \Log::error('Admin authentication failed for payment verification');
            return back()->with('error', 'Admin authentication failed. Please login again.');
        }
        
        // Log admin details
        \Log::debug('Admin authenticated', [
            'admin_id' => $admin->id, 
            'admin_email' => $admin->email
        ]);
        
        // Use database transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            // Find or create QR payment record
            $qrPayment = QrPayment::where('payment_id', $payment->id)->first();
            
            if (!$qrPayment) {
                \Log::info('QR Payment record not found, creating new record');
                $qrPayment = QrPayment::create([
                    'payment_id' => $payment->id,
                    'bank_code' => 'bob', // Set default or get from form
                    'verification_status' => 'pending'
                ]);
                
                \Log::debug('Created new QR payment record', [
                    'qr_payment_id' => $qrPayment->id,
                    'payment_id' => $payment->id
                ]);
            }
            
            // Update the QR payment record
            $qrPayment->update([
                'verification_status' => $request->verification_status,
                'verified_by' => $admin->id, // Use admin ID directly instead of looking up user
                'verified_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);
            
            \Log::debug('QR Payment updated', [
                'qr_payment_id' => $qrPayment->id,
                'new_verification_status' => $request->verification_status,
                'verified_by' => $admin->id
            ]);
            
            // Update the main payment status
            $newPaymentStatus = $request->verification_status === 'confirmed' ? 'completed' : 'failed';
            $payment->update([
                'status' => $newPaymentStatus
            ]);
            
            \Log::debug('Main payment record updated', [
                'payment_id' => $payment->id,
                'old_status' => $payment->getOriginal('status'),
                'new_status' => $newPaymentStatus
            ]);
            
            // Commit the transaction
            DB::commit();
            
            // Log successful verification
            \Log::info('Payment verification completed successfully', [
                'payment_id' => $payment->id,
                'verification_status' => $request->verification_status,
                'payment_status' => $newPaymentStatus,
                'admin_id' => $admin->id
            ]);
            
            $successMessage = $request->verification_status === 'confirmed' 
                ? 'Payment has been confirmed successfully!' 
                : 'Payment has been rejected.';
                
            return redirect()->route('admin.payments.show', $payment->id)
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();
            throw $e;
        }
    
    } catch (\Exception $e) {
        \Log::error('Exception in verifyQrPayment', [
            'payment_id' => $paymentId,
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return back()->with('error', 'An error occurred during verification: ' . $e->getMessage());
    }
}

public function verifyBankTransfer(Request $request, $paymentId)
{
    $payment = Payment::findOrFail($paymentId);
    
    // Validate request
    $request->validate([
        'verification_status' => 'required|in:confirmed,rejected',
        'admin_notes' => 'nullable|string',
    ]);
    
    // Update the payment status directly since we don't have a bankTransfer table/model
    // Use the verification status to determine the payment status
    $payment->status = $request->verification_status === 'confirmed' ? 'completed' : 'failed';
    
    // Store admin notes in a way that fits with your current schema
    // You might want to consider adding a notes column to payments table if you need this
    // Or store it in a more generic verification_notes table
    
    $payment->save();
    
    return redirect()->route('admin.payments.show', $payment->id)
        ->with('success', 'Bank transfer payment has been ' . 
               ($request->verification_status === 'confirmed' ? 'confirmed' : 'rejected'));
}

    /**
     * Process Pay Later payment collection
     */
    public function collectPayLater(Request $request, $id)
{
    $payLaterPayment = PayLaterPayment::where('payment_id', $id)->firstOrFail();
    
    $validatedData = $request->validate([
        'collection_method' => 'required|in:cash,card,bank_transfer,qr_code',
        'notes' => 'nullable|string|max:500',
        'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Added screenshot validation
    ]);
    
    // Start transaction for data integrity
    DB::beginTransaction();
    
    try {
        $payLaterPayment->status = 'paid';
        $payLaterPayment->collection_date = now();
        $payLaterPayment->collected_by_admin = auth()->guard('admin')->user()->name;
        $payLaterPayment->collection_method = $validatedData['collection_method'];
        $payLaterPayment->notes = $validatedData['notes'];
        
        // Get the payment to access its reference number
        $payment = Payment::findOrFail($id);
        
        // Handle screenshot upload for QR payments
        if ($request->hasFile('screenshot') && $validatedData['collection_method'] === 'qr_code') {
            $screenshot = $request->file('screenshot');
            $filename = $payment->reference_number . '.' . $screenshot->getClientOriginalExtension();
            
            // Make sure the directory exists
            $directory = public_path('pay_later_payments');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move the uploaded file
            $screenshot->move($directory, $filename);
            
            // Update the screenshot path in the database
            $payLaterPayment->screenshot_image_path = 'pay_later_payments/' . $filename;
        }
        
        $payLaterPayment->save();
        
        // Update the main payment status
        $payment->status = 'completed';
        $payment->save();
        
        DB::commit();
        
        return redirect()->route('admin.payments.show', $id)
            ->with('success', 'Pay Later payment collected successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error collecting payment: ' . $e->getMessage());
    }
}
}