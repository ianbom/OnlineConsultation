<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionLog extends Model
{
    use HasFactory;

    protected $table = 'session_logs';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
