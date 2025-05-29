<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarAdditionalImage;


class AdminCar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_cars_tbl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'admin_id',
        'number_of_doors',
        'number_of_seats',
        'transmission_type',
        'large_bags_capacity',
        'small_bags_capacity',
        'fuel_type',
        'air_conditioning',
        'backup_camera',
        'bluetooth'
    ];

    /**
     * Get the admin that owns the car.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the car images associated with the car.
     */
    // public function adminCarImages()
    // {
    //     return $this->hasMany(AdminCarImage::class, 'car_id');
    // }
    
    
    public function carImages()
    {
        return $this->hasMany(AdminCarImage::class, 'car_id');
    }

//     public function carImages()
// {
//     return $this->hasMany(CarAdditionalImage::class, 'car_id', 'id');
// }


    /**
     * Get additional images for the car
     */
    public function additionalImages()
    {
        return $this->hasMany(CarAdditionalImage::class, 'car_id', 'id');
    }
    
    
    /**
     * Get all images (primary + additional) as a collection
     */
    public function getAllImages()
    {
        $images = collect();
        
        // Add primary image
        if ($this->car_image) {
            $images->push((object)[
                'image_path' => $this->car_image,
                'is_primary' => true
            ]);
        }
        
        // Add additional images
        $images = $images->merge($this->additionalImages);
        
        return $images;
    }
    public function bookings()
    {
        return $this->hasMany(CarBooking::class, 'car_id');
    }

     // Custom accessor for image path
    public function getImageUrlAttribute()
    {
        if (empty($this->car_image)) {
            return null;
        }

        $imagePath = $this->car_image;
        
        // Determine the correct path based on who uploaded the car
        if ($this->admin_id) {
            // Admin uploaded cars - stored in admincar_images directory
            if (!str_starts_with($imagePath, 'admincar_images/')) {
                $imagePath = 'admincar_images/' . $imagePath;
            }
        } elseif ($this->car_owner_id) {
            // Car owner uploaded cars - stored in uploads/cars directory
            if (!str_starts_with($imagePath, 'uploads/')) {
                $imagePath = 'uploads/cars/' . $imagePath;
            }
        }
        
        // Check if file exists
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        // Fallback: try the original path
        if (file_exists(public_path($this->car_image))) {
            return asset($this->car_image);
        }
        
        return null;
    }

    // Check if image exists
    public function hasImageAttribute()
    {
        return !empty($this->image_url);
    }

    // Custom accessor to handle string boolean values
    public function getAirConditioningAttribute($value)
    {
        return $value === 'Yes' || $value === true || $value === 1;
    }

    public function getBackupCameraAttribute($value)
    {
        return $value === 'Yes' || $value === true || $value === 1;
    }

    public function getBluetoothAttribute($value)
    {
        return $value === 'Yes' || $value === true || $value === 1;
    }

    // Scope to get only available cars
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}