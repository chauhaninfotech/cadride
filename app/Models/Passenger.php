<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'country_code',
        'contact',
        'password',
        'address',
        'city',
        'subpoint',
        'postal_code',
        'passenger_type',
        'tag',
        'user_image',
        'role',
        'otp_key',
        'verify',
        'status',
        'fcm_token',
        'is_first_booking',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'otp_key',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verify' => 'boolean',
            'status' => 'boolean',
            'is_first_booking' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
