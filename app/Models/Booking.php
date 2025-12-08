<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id', 'id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function previousSchedule()
    {
        return $this->belongsTo(Schedule::class, 'previous_schedule_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }

    public function sessionLog()
    {
        return $this->hasOne(SessionLog::class, 'booking_id', 'id');
    }
}
