<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarBooking;
class PayLaterPayment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pay_later_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'booking_id',
        'status',
        'collection_date',
        'collected_by_admin',
        'collection_method',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'collection_date' => 'datetime',
    ];

    /**
     * Get the payment that owns the pay later payment.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // In PayLaterPayment.php
    public function carBooking()
    {
        return $this->belongsTo(CarBooking::class, 'booking_id');
    }


    // In PayLaterPayment.php
  


    /**
     * Status options for Pay Later payments
     */
    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending Collection',
            'paid' => 'Payment Collected',
            'cancelled' => 'Payment Cancelled',
        ];
    }

    /**
     * Collection method options
     */
    public static function collectionMethodOptions(): array
    {
        return [
            'cash' => 'Cash',
            'card' => 'Card',
            'bank_transfer' => 'Bank Transfer',
            'qr_code' => 'QR Code',
        ];
    }
}