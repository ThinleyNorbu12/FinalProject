<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class InspectionDecision extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'inspection_request_id',
//         'decision',
//         'admin_id',
//         'remarks',
//         'updated_at',
//         'created_at'
//     ];

//     /**
//      * Get the inspection request associated with the decision.
//      */
//     public function inspectionRequest()
//     {
//         return $this->belongsTo(InspectionRequest::class, 'inspection_request_id');
//     }

//     /**
//      * Get the admin who made the decision.
//      */
//     public function admin()
//     {
//         return $this->belongsTo(Admin::class, 'admin_id');
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionDecision extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_request_id',
        'decision',
        'admin_id',
        'remarks',
        'updated_at',
        'created_at'
    ];

    /**
     * Get the inspection request associated with the decision.
     */
    public function inspectionRequest()
    {
        return $this->belongsTo(InspectionRequest::class, 'inspection_request_id');
    }

    /**
     * Get the admin who made the decision.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}