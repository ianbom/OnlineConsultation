<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    use HasFactory;

    protected $table = 'counselors';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'price_per_session' => 'integer',
        'online_price_per_session' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workDays()
    {
        return $this->hasMany(CounselorsWorkDay::class, 'counselor_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'counselor_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'counselor_id');
    }
}
