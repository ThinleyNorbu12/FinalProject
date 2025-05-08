<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrivingLicense extends Model
{

    protected $table = 'driving_licenses';

    protected $fillable = [
        'customer_id',
        'license_no',
        'issuing_dzongkhag',
        'issue_date',
        'expiry_date',
        'license_front_image',
        'license_back_image',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
