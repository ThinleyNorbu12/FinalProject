<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetail extends Model
{
    use HasFactory;

    protected $table = 'car_details_tbl';

    protected $fillable = [
        'maker', 
        'model', 
        'vehicle_type', 
        'car_condition', 
        'mileage', 
        'price', 
        'registration_no', 
        'status', 
        'description', 
        'car_image', 
        'car_owner_id'
    ];

    protected $casts = [
        'price' => 'float',
        'mileage' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(CarOwner::class, 'car_owner_id');
    }
}