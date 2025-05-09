<?php

// namespace App\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class Customer extends Authenticatable
// {
//     use Notifiable;

//     protected $guard = 'customer';

//     protected $fillable = [
//         'name',
//         'email',
//         'phone',
//         'cid_no',
//         'password',
//         'date_of_birth',   // ✅ Newly added
//         'address',         // ✅ Newly added
//         'gender',
//     ];

//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     protected $casts = [
//         'email_verified_at' => 'datetime',
//     ];
//     public function drivingLicense()
//     {
//         return $this->hasOne(DrivingLicense::class);
//     }
//     // app/Models/Customer.php

//     public function hasValidDrivingLicense()
//     {
//         return $this->drivingLicense && 
//             $this->drivingLicense->expiry_date > now() &&
//             $this->drivingLicense->license_front_image &&
//             $this->drivingLicense->license_back_image;
//     }

// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cid_no',
        'password',
        'date_of_birth',
        'address',
        'gender',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the driving license associated with the customer
     */
    public function drivingLicense()
    {
        return $this->hasOne(DrivingLicense::class);
    }
    
    /**
     * Check if customer has complete verification information
     */
    public function hasCompleteVerificationInfo()
    {
        // Check if customer has submitted license information
        return $this->drivingLicense()->exists();
    }
    
    /**
     * Get verification status
     */
    public function getVerificationStatus()
    {
        if (!$this->hasCompleteVerificationInfo()) {
            return 'Incomplete';
        }
        
        return $this->drivingLicense->status;
    }

    public function adminNotifications()
    {
        return $this->hasMany(AdminNotification::class);
    }
}