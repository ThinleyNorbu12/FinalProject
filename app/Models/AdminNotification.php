<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'title',
        'message',
        'is_read',
        'type'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the customer that owns the notification.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}