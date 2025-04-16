<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetail extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'car_details_tbl';  // Ensure this matches the migration table name

    // Define fillable attributes
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

    // Define the relationship with the CarOwner model
    public function owner()
    {
        return $this->belongsTo(CarOwner::class, 'car_owner_id');
    }

    public function inspectionRequests()
    {
        return $this->hasMany(InspectionRequest::class, 'car_id');
    }

  

    
}
