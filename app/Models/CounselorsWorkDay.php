<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorsWorkDay extends Model
{
    use HasFactory;

    protected $table = 'counselors_work_days';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'integer'
    ];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }
}
