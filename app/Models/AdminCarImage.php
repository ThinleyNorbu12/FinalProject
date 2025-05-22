<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCarImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_car_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_id',
        'image_path',
        'is_primary'
    ];

    /**
     * Get the car that owns the image.
     */
    public function car()
    {
        return $this->belongsTo(AdminCar::class, 'car_id');
    }
    public function adminCar()
    {
        return $this->belongsTo(AdminCar::class, 'car_id');
    }
}