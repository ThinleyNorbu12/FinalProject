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
    public function adminCarImages()
    {
        return $this->hasMany(AdminCarImage::class, 'car_id');
    }
    public function images()
    {
        return $this->hasMany(AdminCarImage::class, 'car_id');
    }

    public function carImages()
{
    return $this->hasMany(CarAdditionalImage::class, 'car_id', 'id');
}


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
}