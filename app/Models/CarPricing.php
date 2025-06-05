<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPricing extends Model
{
    use HasFactory;

    protected $table = 'car_pricing';

    protected $fillable = [
        'car_id',
        'rate_per_day',
        'price_per_km',
        'mileage_limit',
        'current_mileage',
        'is_active'
    ];

    protected $casts = [
        'rate_per_day' => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationship with Car
    public function car()
    {
        return $this->belongsTo(CarDetail::class, 'car_id');
    }
}