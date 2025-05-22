<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminCar; 

class CarAdditionalImage extends Model
{
    protected $table = 'car_additional_images';
    
    protected $fillable = [
        'car_id', // Changed from car_id to admin_car_id
        'image_path'
    ];

    public function car()
    {
        return $this->belongsTo(AdminCar::class, 'car_id');
    }

}