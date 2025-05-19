<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrPayment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qr_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'bank_code',
        'screenshot_path',
        'verification_status',
        'verified_by',
        'verified_at',
        'admin_notes'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Get the booking that owns the QR payment.
     */
    public function booking()
    {
        return $this->belongsTo(CarBooking::class, 'payment_id', 'id');
    }

    /**
     * Get the user who verified this payment.
     */
     public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    /**
     * Get the user who verified this payment.
     */
    // public function verifier()
    // {
    //     return $this->belongsTo(User::class, 'verified_by');
    // }
    public function verifiedBy()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

}