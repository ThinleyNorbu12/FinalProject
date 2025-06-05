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
//         // 'mileage', 
//         // 'price', 
//         'registration_no', 
//         'status', 
//         'description', 
//         'car_image', 
//         'car_owner_id',
//         'number_of_doors',      // Added field
//         'number_of_seats',      // Added field
//         'transmission_type',    // Added field
//         'large_bags_capacity',  // Added field
//         'small_bags_capacity',  // Added field
//         'fuel_type',            // Added field
//         'air_conditioning',     // Added field
//         'backup_camera',        // Added field
//         'bluetooth'             // Added field
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

//     public function images()
//     {
//         return $this->hasMany(CarImage::class, 'car_id');
//     }

//     // In your Car model
//     public function getImagePathAttribute()
//     {
//         return $this->car_image ? asset('storage/' . $this->car_image) : null;
//     }

//     public function getRecommendedCars()
//     {
//         // Get cars that are available (status = 'available')
//         $recommendedCars = CarDetails::where('status', 'available')
//             ->orderBy('created_at', 'desc')
//             ->take(6) // Get 6 recommended cars
//             ->get();

//         return view('your-view-name', compact('recommendedCars'));
//     }
//     // In your Car model
//     public function additionalImages()
//     {
//         return $this->hasMany(CarImage::class); // or whatever your additional images model is called
//     }
//      public function bookings()
//     {
//         return $this->hasMany(CarBooking::class, 'car_id');
//     }

//     public function pricing()
//     {
//         return $this->hasOne(CarPricing::class, 'car_id')->where('is_active', true);
//     }


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
        'bluetooth',            // Added field
        // Pricing fields (added by admin)
        'rate_per_day',         // Daily rental rate
        'price_per_km',         // Price per km for exceeding mileage limit
        'mileage_limit',        // Daily mileage limit in km
        'current_mileage',      // Current vehicle mileage
        'pricing_active'        // Whether pricing is active for this car
    ];

    // Cast attributes to proper types
    protected $casts = [
        'pricing_active' => 'boolean',
        'rate_per_day' => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'mileage_limit' => 'integer',
        'current_mileage' => 'integer',
        'number_of_doors' => 'integer',
        'number_of_seats' => 'integer',
        'large_bags_capacity' => 'integer',
        'small_bags_capacity' => 'integer'
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

    // In your Car model
    public function additionalImages()
    {
        return $this->hasMany(CarImage::class); // or whatever your additional images model is called
    }
    
    public function bookings()
    {
        return $this->hasMany(CarBooking::class, 'car_id');
    }

    // Helper methods for pricing
    public function hasPricing()
    {
        return $this->pricing_active && 
               !is_null($this->rate_per_day) && 
               !is_null($this->price_per_km) && 
               !is_null($this->mileage_limit) && 
               !is_null($this->current_mileage);
    }

    public function isAvailableForRental()
    {
        return $this->status === 'approved' && $this->hasPricing();
    }

    public function getFormattedDailyRateAttribute()
    {
        return $this->rate_per_day ? '$' . number_format($this->rate_per_day, 2) : 'Not set';
    }

    public function getFormattedPricePerKmAttribute()
    {
        return $this->price_per_km ? '$' . number_format($this->price_per_km, 2) : 'Not set';
    }

    // Scope for available cars
    public function scopeAvailableForRental($query)
    {
        return $query->where('status', 'approved')
                    ->where('pricing_active', true)
                    ->whereNotNull('rate_per_day')
                    ->whereNotNull('price_per_km')
                    ->whereNotNull('mileage_limit')
                    ->whereNotNull('current_mileage');
    }

    // Scope for cars needing pricing
    public function scopeNeedsPricing($query)
    {
        return $query->where('status', 'approved')
                    ->where(function($q) {
                        $q->where('pricing_active', false)
                          ->orWhereNull('rate_per_day')
                          ->orWhereNull('price_per_km')
                          ->orWhereNull('mileage_limit')
                          ->orWhereNull('current_mileage');
                    });
    }
}



