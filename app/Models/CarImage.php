<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $table = 'car_images';
    
    protected $fillable = [
        'car_id',
        'image_path',
        'is_primary'
    ];

    public function car()
    {
        return $this->belongsTo(CarDetail::class, 'car_id');
    }
}