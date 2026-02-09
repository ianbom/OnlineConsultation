<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }

    public function workday()
    {
        return $this->belongsTo(CounselorsWorkDay::class, 'workday_id')->withTrashed();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }
}
