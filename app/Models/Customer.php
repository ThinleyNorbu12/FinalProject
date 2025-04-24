<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer'; // Tells Laravel which guard this model uses

    protected $fillable = [
        'name',
        'email',
        'phone',     // ✅ Add this
        'cid_no',    // ✅ Add this
        'password',  // Optional if you’re setting it later
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
