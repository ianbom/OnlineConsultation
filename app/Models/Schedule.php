<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }
}
