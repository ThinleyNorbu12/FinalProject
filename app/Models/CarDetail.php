<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarDetail extends Model
// {
//     use HasFactory;

//     // Define the table name explicitly
//     protected $table = 'car_details_tbl';  // Ensure this matches the migration table name

//     // Define fillable attributes
//     protected $fillable = [
//         'maker', 
//         'model', 
//         'vehicle_type', 
//         'car_condition', 
//         'mileage', 
//         'price', 
//         'registration_no', 
//         'status', 
//         'description', 
//         'car_image', 
//         'car_owner_id'
//     ];

//     // Define the relationship with the CarOwner model
//     public function owner()
//     {
//         return $this->belongsTo(CarOwner::class, 'car_owner_id');
//     }

//     public function inspectionRequests()
//     {
//         return $this->hasMany(InspectionRequest::class, 'car_id');
//     }
//     // Add this in CarDetail.php model
//     public function inspectionDecision()
//     {
//         return $this->hasOneThrough(
//             \App\Models\InspectionDecision::class,  // Final model
//             \App\Models\InspectionRequest::class,   // Middle model
//             'car_id',                               // Foreign key on inspection_requests table
//             'inspection_request_id',                // Foreign key on inspection_decisions table
//             'id',                                   // Local key on car_details_tbl
//             'id'                                    // Local key on inspection_requests
//         );
//     }
// }



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
        'car_owner_id',
        'number_of_doors',      // Added field
        'number_of_seats',      // Added field
        'transmission_type',    // Added field
        'large_bags_capacity',  // Added field
        'small_bags_capacity',  // Added field
        'fuel_type',            // Added field
        'air_conditioning',     // Added field
        'backup_camera',        // Added field
        'bluetooth'             // Added field
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

    // Add this in CarDetail.php model
    public function inspectionDecision()
    {
        return $this->hasOneThrough(
            \App\Models\InspectionDecision::class,  // Final model
            \App\Models\InspectionRequest::class,   // Middle model
            'car_id',                               // Foreign key on inspection_requests table
            'inspection_request_id',                // Foreign key on inspection_decisions table
            'id',                                   // Local key on car_details_tbl
            'id'                                    // Local key on inspection_requests
        );
    }

    public function images()
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }

    // In your Car model
    public function getImagePathAttribute()
    {
        return $this->car_image ? asset('storage/' . $this->car_image) : null;
    }

    public function getRecommendedCars()
    {
        // Get cars that are available (status = 'available')
        $recommendedCars = CarDetails::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->take(6) // Get 6 recommended cars
            ->get();

        return view('your-view-name', compact('recommendedCars'));
    }
    // In your Car model
    public function additionalImages()
    {
        return $this->hasMany(CarImage::class); // or whatever your additional images model is called
    }
     public function bookings()
    {
        return $this->hasMany(CarBooking::class, 'car_id');
    }

}
