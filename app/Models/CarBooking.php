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
    protected $fillable = [
        'car_id', 
        'customer_id',
        'pickup_location', 
        'pickup_datetime',
        'dropoff_location', 
        'dropoff_datetime',
        'status'
    ];

    protected $casts = [
        'pickup_datetime' => 'datetime',
        'dropoff_datetime' => 'datetime',
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

    // CarBooking.php
    public function getTotalPriceAttribute()
    {
        $hours = $this->pickup_datetime->diffInHours($this->dropoff_datetime);
        $days = ceil($hours / 24);
        return ($this->car->price * $days) + 200 + 100; // Insurance + service fee
    }
}