<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'payment_method',
        'amount',
        'currency',
        'status',
        'reference_number',
        'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Relationship to Booking
     */
    // public function booking()
    // {
    //     return $this->belongsTo(CarBooking::class, 'booking_id');
    // }

    public function carBooking()
    {
        return $this->belongsTo(CarBooking::class, 'booking_id');
    }

    public function payLaterPayment()
    {
        return $this->hasOne(PayLaterPayment::class);
    }

    /**
     * Relationship to Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship to QR Payment details
     */
    public function qrPayment()
    {
        return $this->hasOne(QrPayment::class, 'payment_id');
    }

    /**
     * Status options
     */
    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'completed' => 'Paid',
            'failed' => 'Failed',
            'pending_verification' => 'Pending Verification',
            'refunded' => 'Refunded',
        ];
    }

    /**
     * Payment method options
     */
    public static function methodOptions(): array
    {
        return [
            'qr_code' => 'QR Code',
            'bank_transfer' => 'Bank Transfer',
            'pay_later' => 'Pay Later',
            'card' => 'Credit/Debit Card',
        ];
    }
}