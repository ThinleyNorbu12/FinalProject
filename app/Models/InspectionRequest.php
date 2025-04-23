<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'inspection_date',
        'inspection_time',
        'location',
        'details',
        'status',
    ];

    public function car()
    {
        return $this->belongsTo(CarDetail::class, 'car_id');
    }
    
    public function decision()
    {
        return $this->hasOne(InspectionDecision::class);
    }


    


}

