<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecordMileageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // Base query for pickup bookings - exclude cancelled bookings
        $pickupQuery = DB::table('car_bookings')
            ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
            ->join('customers', 'car_bookings.customer_id', '=', 'customers.id')
            ->leftJoin('mileage_records', function($join) {
                $join->on('car_bookings.id', '=', 'mileage_records.booking_id')
                     ->where('mileage_records.record_type', '=', 'pickup');
            })
            ->where('car_bookings.status', 'confirmed')
            ->whereNull('mileage_records.id'); // Only bookings without pickup records

        // Apply search filters for pickup bookings
        if ($search) {
            $pickupQuery->where(function($query) use ($search) {
                $query->where('car_bookings.id', 'LIKE', "%{$search}%")
                      ->orWhere('customers.name', 'LIKE', "%{$search}%")
                      ->orWhere('customers.email', 'LIKE', "%{$search}%")
                      ->orWhereRaw("CONCAT(car_details_tbl.maker, ' ', car_details_tbl.model) LIKE ?", ["%{$search}%"])
                      ->orWhere('car_details_tbl.registration_no', 'LIKE', "%{$search}%");
            });
        }

        $pickupBookings = $pickupQuery->select(
                'car_bookings.*',
                'car_details_tbl.maker',
                'car_details_tbl.model',
                'car_details_tbl.registration_no',
                'car_details_tbl.current_mileage',
                'car_details_tbl.mileage_limit',
                'customers.name as customer_name',
                'customers.email as customer_email'
            )
            ->orderBy('car_bookings.pickup_datetime', 'asc')
            ->get();

        // Base query for return bookings - exclude cancelled bookings
        $returnQuery = DB::table('car_bookings')
            ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
            ->join('customers', 'car_bookings.customer_id', '=', 'customers.id')
            ->join('mileage_records as pickup_record', function($join) {
                $join->on('car_bookings.id', '=', 'pickup_record.booking_id')
                     ->where('pickup_record.record_type', '=', 'pickup');
            })
            ->leftJoin('mileage_records as return_record', function($join) {
                $join->on('car_bookings.id', '=', 'return_record.booking_id')
                     ->where('return_record.record_type', '=', 'return');
            })
            // Exclude cancelled bookings from return records
            ->whereNotIn('car_bookings.status', ['cancelled', 'canceled'])
            ->whereNull('return_record.id'); // Only show bookings without return records

        // Apply search filters for return bookings
        if ($search) {
            $returnQuery->where(function($query) use ($search) {
                $query->where('car_bookings.id', 'LIKE', "%{$search}%")
                      ->orWhere('customers.name', 'LIKE', "%{$search}%")
                      ->orWhere('customers.email', 'LIKE', "%{$search}%")
                      ->orWhereRaw("CONCAT(car_details_tbl.maker, ' ', car_details_tbl.model) LIKE ?", ["%{$search}%"])
                      ->orWhere('car_details_tbl.registration_no', 'LIKE', "%{$search}%");
            });
        }

        $returnBookings = $returnQuery->select(
                'car_bookings.*',
                'car_details_tbl.maker',
                'car_details_tbl.model',
                'car_details_tbl.registration_no',
                'car_details_tbl.current_mileage',
                'car_details_tbl.mileage_limit',
                'car_details_tbl.price_per_km',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'pickup_record.mileage_at_pickup',
                'pickup_record.fuel_level_pickup',
                'pickup_record.pickup_notes',
                'pickup_record.mileage_at_return',
                'pickup_record.fuel_level_return',
                'pickup_record.return_notes',
                'pickup_record.car_condition_return',
                'pickup_record.damage_reported',
                'pickup_record.damage_description',
                'pickup_record.mileage_used',
                'pickup_record.excess_mileage',
                'pickup_record.excess_charges',
                'pickup_record.return_recorded_at'
            )
            ->orderBy('car_bookings.dropoff_datetime', 'asc')
            ->get();

        // Get cancelled bookings that had pickup records (for reference/history)
        $cancelledBookings = DB::table('car_bookings')
            ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
            ->join('customers', 'car_bookings.customer_id', '=', 'customers.id')
            ->join('mileage_records as pickup_record', function($join) {
                $join->on('car_bookings.id', '=', 'pickup_record.booking_id')
                     ->where('pickup_record.record_type', '=', 'pickup');
            })
            ->whereIn('car_bookings.status', ['cancelled', 'canceled'])
            ->select(
                'car_bookings.*',
                'car_details_tbl.maker',
                'car_details_tbl.model',
                'car_details_tbl.registration_no',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'pickup_record.mileage_at_pickup',
                'pickup_record.mileage_at_return'
            )
            ->orderBy('car_bookings.updated_at', 'desc')
            ->get();

        return view('admin.record-mileage.index', compact('pickupBookings', 'returnBookings', 'cancelledBookings', 'search'));
    }

    // public function recordPickup(Request $request)
    // {
    //     $request->validate([
    //         'booking_id' => 'required|exists:car_bookings,id',
    //         'mileage_at_pickup' => 'required|integer|min:0',
    //         'fuel_level_pickup' => 'required|string|in:Empty,1/4,1/2,3/4,Full',
    //         'pickup_notes' => 'nullable|string|max:500',
    //         'car_condition_pickup' => 'nullable|string|max:500'
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Check if booking is still confirmed (not cancelled)
    //         $booking = DB::table('car_bookings')->where('id', $request->booking_id)->first();
            
    //         if (!$booking) {
    //             throw new \Exception('Booking not found.');
    //         }

    //         if (in_array($booking->status, ['cancelled', 'canceled'])) {
    //             throw new \Exception('Cannot record pickup for cancelled booking.');
    //         }

    //         if ($booking->status !== 'confirmed') {
    //             throw new \Exception('Booking must be confirmed to record pickup.');
    //         }

    //         // Insert mileage record
    //         DB::table('mileage_records')->insert([
    //             'booking_id' => $request->booking_id,
    //             'record_type' => 'pickup',
    //             'mileage_at_pickup' => $request->mileage_at_pickup,
    //             'fuel_level_pickup' => $request->fuel_level_pickup,
    //             'pickup_notes' => $request->pickup_notes,
    //             'car_condition_pickup' => $request->car_condition_pickup,
    //             'recorded_by' => auth()->id() ?? 1,
    //             'recorded_at' => now(),
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         // Update car's current mileage
    //         DB::table('car_details_tbl')
    //             ->where('id', $booking->car_id)
    //             ->update(['current_mileage' => $request->mileage_at_pickup]);

    //         // Update booking status to picked_up
    //         DB::table('car_bookings')
    //             ->where('id', $request->booking_id)
    //             ->update(['status' => 'picked_up']);

    //         DB::commit();

    //         return redirect()->route('car-admin.record-mileage')
    //                        ->with('success', 'Pickup mileage recorded successfully!');

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()
    //                        ->with('error', 'Failed to record pickup mileage: ' . $e->getMessage());
    //     }
    // }
    public function recordPickup(Request $request)
{
    $request->validate([
        'booking_id' => 'required|exists:car_bookings,id',
        'mileage_at_pickup' => 'required|integer|min:0',
        'fuel_level_pickup' => 'required|string|in:Empty,1/4,1/2,3/4,Full',
        'pickup_notes' => 'nullable|string|max:500',
        'car_condition_pickup' => 'nullable|string|max:500'
    ]);

    try {
        DB::beginTransaction();

        // Check if booking is still confirmed (not cancelled)
        $booking = DB::table('car_bookings')->where('id', $request->booking_id)->first();
        
        if (!$booking) {
            throw new \Exception('Booking not found.');
        }

        if (in_array($booking->status, ['cancelled', 'canceled'])) {
            throw new \Exception('Cannot record pickup for cancelled booking.');
        }

        if ($booking->status !== 'confirmed') {
            throw new \Exception('Booking must be confirmed to record pickup.');
        }

        // Insert mileage record
        DB::table('mileage_records')->insert([
            'booking_id' => $request->booking_id,
            'record_type' => 'pickup',
            'mileage_at_pickup' => $request->mileage_at_pickup,
            'fuel_level_pickup' => $request->fuel_level_pickup,
            'pickup_notes' => $request->pickup_notes,
            'car_condition_pickup' => $request->car_condition_pickup,
            'recorded_by' => auth()->id() ?? 1,
            'recorded_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update car's current mileage
        DB::table('car_details_tbl')
            ->where('id', $booking->car_id)
            ->update(['current_mileage' => $request->mileage_at_pickup]);

        // Update booking status - use one of these options based on your ENUM values:
        // Option 1: Keep as 'confirmed' (safest option)
        // No status update needed
        
        // Option 2: Use 'active' if that's an allowed value
        // DB::table('car_bookings')
        //     ->where('id', $request->booking_id)
        //     ->update(['status' => 'active']);
        
        // Option 3: Use 'ongoing' if that's an allowed value
        // DB::table('car_bookings')
        //     ->where('id', $request->booking_id)
        //     ->update(['status' => 'ongoing']);

        // Option 4: Use 'in_progress' if that's an allowed value
        // DB::table('car_bookings')
        //     ->where('id', $request->booking_id)
        //     ->update(['status' => 'in_progress']);

        DB::commit();

        return redirect()->route('car-admin.record-mileage')
                       ->with('success', 'Pickup mileage recorded successfully!');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()
                       ->with('error', 'Failed to record pickup mileage: ' . $e->getMessage());
    }
}

    public function recordReturn(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:car_bookings,id',
            'mileage_at_return' => 'required|integer|min:0',
            'fuel_level_return' => 'required|string|in:Empty,1/4,1/2,3/4,Full',
            'return_notes' => 'nullable|string|max:500',
            'car_condition_return' => 'nullable|string|max:500',
            'damage_reported' => 'nullable|string|in:Yes,No',
            'damage_description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Check if booking is not cancelled
            $bookingCheck = DB::table('car_bookings')->where('id', $request->booking_id)->first();
            
            if (in_array($bookingCheck->status, ['cancelled', 'canceled'])) {
                throw new \Exception('Cannot record return for cancelled booking.');
            }

            // Get pickup record and booking details
            $pickupRecord = DB::table('mileage_records')
                ->where('booking_id', $request->booking_id)
                ->where('record_type', 'pickup')
                ->first();

            if (!$pickupRecord) {
                throw new \Exception('Pickup record not found. Cannot process return without pickup record.');
            }

            $booking = DB::table('car_bookings')
                ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
                ->where('car_bookings.id', $request->booking_id)
                ->select('car_bookings.*', 'car_details_tbl.mileage_limit', 'car_details_tbl.price_per_km')
                ->first();

            // Calculate mileage used and extra charges
            $mileageUsed = $request->mileage_at_return - $pickupRecord->mileage_at_pickup;
            $rentalDays = Carbon::parse($booking->pickup_datetime)->diffInDays(Carbon::parse($booking->dropoff_datetime)) + 1;
            $allowedMileage = $booking->mileage_limit * $rentalDays;
            $excessMileage = max(0, $mileageUsed - $allowedMileage);
            $excessCharges = $excessMileage * $booking->price_per_km;

            // Validate return mileage is not less than pickup mileage
            if ($request->mileage_at_return < $pickupRecord->mileage_at_pickup) {
                throw new \Exception('Return mileage cannot be less than pickup mileage.');
            }

            // Update mileage record with return information
            DB::table('mileage_records')
                ->where('booking_id', $request->booking_id)
                ->where('record_type', 'pickup')
                ->update([
                    'mileage_at_return' => $request->mileage_at_return,
                    'fuel_level_return' => $request->fuel_level_return,
                    'return_notes' => $request->return_notes,
                    'car_condition_return' => $request->car_condition_return,
                    'damage_reported' => $request->damage_reported ?? 'No',
                    'damage_description' => $request->damage_description,
                    'mileage_used' => $mileageUsed,
                    'excess_mileage' => $excessMileage,
                    'excess_charges' => $excessCharges,
                    'return_recorded_at' => now(),
                    'updated_at' => now()
                ]);

            // Update car's current mileage
            DB::table('car_details_tbl')
                ->where('id', $booking->car_id)
                ->update(['current_mileage' => $request->mileage_at_return]);

            // Update booking status to completed
            DB::table('car_bookings')
                ->where('id', $request->booking_id)
                ->update(['status' => 'completed']);

            DB::commit();

            $message = 'Return mileage recorded successfully!';
            if ($excessCharges > 0) {
                $message .= " Excess mileage charges: Nu. " . number_format($excessCharges, 2);
            }

            return redirect()->route('car-admin.record-mileage')
                           ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Failed to record return mileage: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled bookings that have pickup records
     */
    public function handleCancelledBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:car_bookings,id',
            'cancellation_reason' => 'required|string|max:500',
            'refund_mileage_charges' => 'nullable|boolean'
        ]);

        try {
            DB::beginTransaction();

            $booking = DB::table('car_bookings')->where('id', $request->booking_id)->first();
            
            // Check if there's a pickup record
            $pickupRecord = DB::table('mileage_records')
                ->where('booking_id', $request->booking_id)
                ->where('record_type', 'pickup')
                ->first();

            if ($pickupRecord && !$pickupRecord->mileage_at_return) {
                // Car was picked up but not returned - handle this case
                // You might want to force a return record or handle specially
                throw new \Exception('Cannot cancel booking - car was picked up but not yet returned. Please process return first.');
            }

            // Update booking status
            DB::table('car_bookings')
                ->where('id', $request->booking_id)
                ->update([
                    'status' => 'cancelled',
                    'cancellation_reason' => $request->cancellation_reason,
                    'cancelled_at' => now(),
                    'cancelled_by' => auth()->id()
                ]);

            // If there are excess charges and refund is requested
            if ($pickupRecord && $pickupRecord->excess_charges > 0 && $request->refund_mileage_charges) {
                // Handle refund logic here
                // You might want to create a refund record or update payment status
            }

            DB::commit();

            return redirect()->route('car-admin.record-mileage')
                           ->with('success', 'Booking cancelled successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Failed to cancel booking: ' . $e->getMessage());
        }
    }

    public function getMileageHistory($bookingId)
    {
        $record = DB::table('mileage_records')
            ->join('car_bookings', 'mileage_records.booking_id', '=', 'car_bookings.id')
            ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
            ->join('customers', 'car_bookings.customer_id', '=', 'customers.id')
            ->where('mileage_records.booking_id', $bookingId)
            ->select(
                'mileage_records.*',
                'car_details_tbl.maker',
                'car_details_tbl.model',
                'car_details_tbl.registration_no',
                'customers.name as customer_name',
                'car_bookings.status as booking_status'
            )
            ->first();

        return response()->json($record);
    }





    public function processExcessPayment(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:cash,qr_code,bank_transfer,card,pay_later',
            'payment_amount' => 'required|numeric|min:0',
            'payment_notes' => 'nullable|string|max:1000',
            
            // QR Code specific fields
            'qr_screenshot' => 'nullable|image|max:5120', // 5MB max
            'qr_bank_code' => 'nullable|string',
            
            // Bank Transfer specific fields
            'bank_name' => 'nullable|string|max:255',
            'transfer_reference' => 'nullable|string|max:255',
            'transfer_date' => 'nullable|date',
            'bank_receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            
            // Card Payment specific fields
            'card_type' => 'nullable|string',
            'card_transaction_id' => 'nullable|string|max:255',
            'card_last_four' => 'nullable|string|max:4',
            'card_receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            
            // Pay Later specific fields
            'due_date' => 'nullable|date|after:today',
            'customer_contact' => 'nullable|string|max:20',
            'pay_later_notes' => 'nullable|string|max:1000',
        ]);

        // Find the booking
        $booking = Booking::findOrFail($validatedData['booking_id']);

        // Handle file uploads
        $uploadedFiles = [];
        
        if ($request->hasFile('qr_screenshot')) {
            $uploadedFiles['qr_screenshot'] = $this->handleFileUpload($request->file('qr_screenshot'), 'payment_screenshots');
        }
        
        if ($request->hasFile('bank_receipt')) {
            $uploadedFiles['bank_receipt'] = $this->handleFileUpload($request->file('bank_receipt'), 'payment_receipts');
        }
        
        if ($request->hasFile('card_receipt')) {
            $uploadedFiles['card_receipt'] = $this->handleFileUpload($request->file('card_receipt'), 'payment_receipts');
        }

        // Create payment record
        $paymentData = [
            'booking_id' => $booking->id,
            'payment_type' => 'excess_mileage',
            'payment_method' => $validatedData['payment_method'],
            'amount' => $validatedData['payment_amount'],
            'payment_status' => $validatedData['payment_method'] === 'pay_later' ? 'pending' : 'completed',
            'payment_date' => now(),
            'notes' => $validatedData['payment_notes'],
            'processed_by' => auth()->id(),
        ];

        // Add method-specific data
        switch ($validatedData['payment_method']) {
            case 'qr_code':
                $paymentData['qr_bank_code'] = $validatedData['qr_bank_code'] ?? null;
                $paymentData['qr_screenshot'] = $uploadedFiles['qr_screenshot'] ?? null;
                break;
                
            case 'bank_transfer':
                $paymentData['bank_name'] = $validatedData['bank_name'];
                $paymentData['transfer_reference'] = $validatedData['transfer_reference'];
                $paymentData['transfer_date'] = $validatedData['transfer_date'];
                $paymentData['bank_receipt'] = $uploadedFiles['bank_receipt'] ?? null;
                break;
                
            case 'card':
                $paymentData['card_type'] = $validatedData['card_type'] ?? null;
                $paymentData['card_transaction_id'] = $validatedData['card_transaction_id'] ?? null;
                $paymentData['card_last_four'] = $validatedData['card_last_four'] ?? null;
                $paymentData['card_receipt'] = $uploadedFiles['card_receipt'] ?? null;
                break;
                
            case 'pay_later':
                $paymentData['due_date'] = $validatedData['due_date'];
                $paymentData['customer_contact'] = $validatedData['customer_contact'] ?? null;
                $paymentData['pay_later_notes'] = $validatedData['pay_later_notes'] ?? null;
                break;
        }

        // Create the payment record (assuming you have a payments table)
        Payment::create($paymentData);

        // Update booking payment status
        $booking->update([
            'excess_payment_status' => $validatedData['payment_method'] === 'pay_later' ? 'pending' : 'paid',
            'excess_payment_method' => $validatedData['payment_method'],
            'excess_payment_date' => $validatedData['payment_method'] !== 'pay_later' ? now() : null,
        ]);

        // Log the activity
        activity()
            ->performedOn($booking)
            ->causedBy(auth()->user())
            ->withProperties(['payment_method' => $validatedData['payment_method'], 'amount' => $validatedData['payment_amount']])
            ->log('Excess mileage payment processed');

        return redirect()->route('car-admin.record-mileage')
            ->with('success', 'Excess mileage payment processed successfully!');

    } catch (\Exception $e) {
        \Log::error('Error processing excess payment: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'Failed to process payment. Please try again.')
            ->withInput();
    }
}

/**
 * Handle file upload
 */
private function handleFileUpload($file, $directory)
{
    try {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/' . $directory, $fileName, 'public');
        
        return $filePath;
    } catch (\Exception $e) {
        \Log::error('File upload error: ' . $e->getMessage());
        throw new \Exception('File upload failed');
    }
}
}