<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'Location';
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'working_hours',
        'description',
        'is_active',
        'map_url',
        'latitude',
        'longitude',
    ];

    /**
     * Get the cars available at this location.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Get the reservations for this location.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}