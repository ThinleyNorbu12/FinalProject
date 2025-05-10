<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class DrivingLicense extends Model
// {

//     protected $table = 'driving_licenses';

//     protected $fillable = [
//         'customer_id',
//         'license_no',
//         'issuing_dzongkhag',
//         'issue_date',
//         'expiry_date',
//         'license_front_image',
//         'license_back_image',
//         'status',
//     ];

//     public function customer()
//     {
//         return $this->belongsTo(Customer::class);
//     }
    
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLicense extends Model
{
    use HasFactory;

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
        'rejection_reason'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_VERIFIED = 'Verified';
    const STATUS_REJECTED = 'Rejected';

    /**
     * Get the customer that owns the driving license
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($license) {
            if (!isset($license->status)) {
                $license->status = self::STATUS_PENDING;
            }
        });
    }

    /**
     * Check if the license is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return now()->greaterThan($this->expiry_date);
    }

    /**
     * Check if the license is about to expire (within 30 days).
     *
     * @return bool
     */
    public function isAboutToExpire()
    {
        return now()->diffInDays($this->expiry_date) <= 30 && !$this->isExpired();
    }

    /**
     * Get the remaining days until expiry
     * 
     * @return int
     */
    public function daysUntilExpiry()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expiry_date);
    }

    /**
     * Get the status of the license with expiry information.
     *
     * @return string
     */
    public function getStatusWithExpiryAttribute()
    {
        if ($this->isExpired()) {
            return 'Expired';
        } elseif ($this->isAboutToExpire()) {
            return 'Expiring Soon';
        } else {
            return $this->status;
        }
    }

    /**
     * Get formatted issue date
     */
    public function getFormattedIssueDateAttribute()
    {
        return $this->issue_date ? $this->issue_date->format('d M Y') : null;
    }

    /**
     * Get formatted expiry date
     */
    public function getFormattedExpiryDateAttribute()
    {
        return $this->expiry_date ? $this->expiry_date->format('d M Y') : null;
    }

    /**
     * Get the status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $status = strtolower($this->status);
        
        $badgeClasses = [
            'pending' => 'badge-warning',
            'verified' => 'badge-success',
            'rejected' => 'badge-danger',
        ];

        $class = $badgeClasses[$status] ?? 'badge-secondary';
        
        return '<span class="badge '.$class.'">'.$this->status.'</span>';
    }
}