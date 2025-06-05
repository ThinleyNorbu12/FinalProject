<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class InspectionRequest extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'car_id',
//         'inspection_date',
//         'inspection_time',
//         'location',
//         'details',
//         'status',
//     ];

//     public function car()
//     {
//         return $this->belongsTo(CarDetail::class, 'car_id');
//     }
    
//     public function decision()
//     {
//         return $this->hasOne(InspectionDecision::class);
//     }


    // }


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
        'request_new_date_sent',
        'request_accepted',
        'date_time_updated',
        'is_confirmed_by_admin',
        'is_confirmed_by_owner'
    ];

    /**
     * Get the car associated with the inspection request.
     */
    public function car()
    {
        return $this->belongsTo(CarDetail::class, 'car_id');
    }

    /**
     * Get the decision associated with the inspection request.
     */
    public function decision()
    {
        return $this->hasOne(InspectionDecision::class, 'inspection_request_id');
    }

    public function inspectionDecision()
    {
        return $this->hasOne(InspectionDecision::class);
    }
}
