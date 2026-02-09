<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselorsWorkDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'counselors_work_days';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'workday_id')->withTrashed();
    }
}
