<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarOwner extends Model {
//     use HasFactory;

//     protected $fillable = ['name', 'phone', 'email', 'address'];
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CarOwner extends Authenticatable
{
    use HasFactory, Notifiable;

    // Custom guard
    protected $guard = 'carowner';

    // Avoid mass assignment vulnerability by using guarded
    protected $guarded = [];

    // Fillable attributes
    protected $fillable = [
        'name',
        'email',
        'password',  // Remember, this will be set after email verification
        'phone',
        'address',
        'email_verified_at',
        'verification_token',
    ];

    // Hidden attributes for arrays
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token', // You might want to keep this hidden for security
    ];

    // Attributes to be cast
    protected $casts = [
        'email_verified_at' => 'datetime',  // Casting to datetime format
        'password' => 'hashed',  // Ensure password is hashed
    ];

    // One-to-many relationship with the cars table
    public function cars()
    {
        return $this->hasMany(CarDetail::class, 'car_owner_id');  // Make sure the foreign key is defined correctly
    }


    // Optional: If you need to send an email verification link manually after registration
    public function sendEmailVerificationNotification()
    {
        // Send verification email logic here.
        // Example: $this->notify(new CarOwnerVerification($this));
    }
}
