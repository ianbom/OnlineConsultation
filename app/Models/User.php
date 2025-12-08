<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function counselor()
    {
        return $this->hasOne(Counselor::class, 'user_id');
    }

    public function bookingsAsClient()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function bookingsAsCounselor()
    {
        return $this->hasMany(Booking::class, 'counselor_id');
    }
}
