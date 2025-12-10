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

    public function secondSchedule()
    {
        return $this->belongsTo(Schedule::class, 'second_schedule_id', 'id');
    }

    public function previousSchedule()
    {
        return $this->belongsTo(Schedule::class, 'previous_schedule_id', 'id');
    }

    public function previousSecondSchedule()
    {
        return $this->belongsTo(Schedule::class, 'previous_second_schedule_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }

    public function sessionLog()
    {
        return $this->hasOne(SessionLog::class, 'booking_id', 'id');
    }

    public function scopeForClient($query, $clientId)
{
    return $query->where('client_id', $clientId);
}

public function scopeUpcoming($query)
{
    return $query->where('status', 'paid');
}

public function scopeCompleted($query)
{
    return $query->where('status', 'completed');
}

public function scopePendingPayment($query)
{
    return $query->where('status', 'pending_payment');
}

public function scopeRecentConsultations($query)
{
    return $query->whereIn('status', ['completed', 'rescheduled'])
                 ->orderBy('created_at', 'desc')
                 ->limit(5);
}

}
