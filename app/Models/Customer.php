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
    
    protected $guard = 'customer';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cid_no',
        'password',
        'date_of_birth',
        'address',
        'gender',
        'profile_image',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];
    
    /**
     * Get the driving license associated with the customer
     */
    // public function drivingLicense()
    // {
    //     return $this->hasOne(DrivingLicense::class);
    // }
    
    /**
     * Check if customer has valid driving license
     */
    public function hasValidDrivingLicense()
    {
        return $this->drivingLicense &&
            $this->drivingLicense->expiry_date > now() && 
            $this->drivingLicense->license_front_image && 
            $this->drivingLicense->license_back_image;
    }
    
    /**
     * Check if customer has complete verification information
     */
    public function hasCompleteVerificationInfo()
    {
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
    
    /**
     * Get admin notifications associated with this customer
     */
    public function adminNotifications()
    {
        return $this->hasMany(AdminNotification::class);
    }
    
    /**
     * Get all cars owned by the customer.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Get all bookings made by the customer.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all payments made by the customer.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     * Check if license is about to expire (within 30 days)
     */
    public function isLicenseAboutToExpire()
    {
        if (!$this->hasValidDrivingLicense()) {
            return false;
        }
        
        $daysUntilExpiry = now()->diffInDays($this->drivingLicense->expiry_date, false);
        return $daysUntilExpiry > 0 && $daysUntilExpiry <= 30;
    }

    /**
     * Get the verification status badge HTML
     */
    public function getVerificationStatusBadge()
    {
        $status = strtolower($this->getVerificationStatus());
        
        $badgeClasses = [
            'incomplete' => 'badge-secondary',
            'pending' => 'badge-warning',
            'verified' => 'badge-success',
            'rejected' => 'badge-danger',
            'expired' => 'badge-dark',
        ];

        $class = $badgeClasses[$status] ?? 'badge-secondary';
        
        return '<span class="badge '.$class.'">'.ucfirst($status).'</span>';
    }
    // In Customer.php model
    public function drivingLicense()
    {
        return $this->hasOne(DrivingLicense::class, 'customer_id');
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('customerprofile/' . $this->profile_image);
        }
        return asset('customerprofile/profile.png'); // Default image
    }

}