<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarBooking extends Model
// {
//     use HasFactory;

//     /**
//      * The table associated with the model.
//      *
//      * @var string
//      */
//     protected $table = 'car_bookings';

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array
//      */
//     protected $fillable = [
//         'car_id',
//         'customer_id',
//         'pickup_location',
//         'pickup_date',
//         'dropoff_location',
//         'dropoff_date',
//         'status', // ✅ Added status field
//     ];

//     /**
//      * Get the car that was booked.
//      */
//     public function car()
//     {
//         return $this->belongsTo(CarDetail::class, 'car_id');
//     }

//     /**
//      * Get the customer who made the booking.
//      */
//     public function customer()
//     {
//         return $this->belongsTo(Customer::class, 'customer_id');
//     }
// }




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'car_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_id',
        'customer_id',
        'pickup_location',
        'pickup_date',
        'dropoff_location',
        'dropoff_date',
        'status',
        'payment_method',
        'payment_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pickup_date' => 'datetime',
        'dropoff_date' => 'datetime',
        'payment_date' => 'datetime',
    ];

    /**
     * Get the car that was booked.
     */
    public function car()
    {
        return $this->belongsTo(CarDetail::class, 'car_id');
    }

    /**
     * Get the customer who made the booking.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}