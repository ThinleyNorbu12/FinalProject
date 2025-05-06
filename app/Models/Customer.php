<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cid_no',
        'password',
        'date_of_birth',   // ✅ Newly added
        'address',         // ✅ Newly added
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function drivingLicense()
    {
        return $this->hasOne(DrivingLicense::class);
    }
    // app/Models/Customer.php

    public function hasValidDrivingLicense()
    {
        return $this->drivingLicense && 
            $this->drivingLicense->expiry_date > now() &&
            $this->drivingLicense->license_front_image &&
            $this->drivingLicense->license_back_image;
    }

}
