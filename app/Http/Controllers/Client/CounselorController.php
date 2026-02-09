<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CounselorController extends Controller
{
    public function counselorList()
    {
        $counselors = Counselor::with('user')->get();


        return Inertia::render('Counselor/CounselorsList', [
            'counselors' => $counselors,
        ]);
    }

    public function detailCounselor($counselorId)
    {
        $counselor = Counselor::with('user', 'workDays', 'schedules')->findOrFail($counselorId);

        return Inertia::render('Counselor/CounselorProfile', [
            'counselor' => $counselor,
        ]);

    }

    public function pickCounselorSchedule($counselorId)
    {
        $counselor = Counselor::with(['user', 'schedules' => function($query) {
            $query->where('is_available', true)
                  ->where('date', '>=', now()->toDateString())
                  ->orderBy('date')
                  ->orderBy('start_time');
        }])->findOrFail($counselorId);
        
        return Inertia::render('Counselor/SchedulePicker', [
            'counselor' => $counselor,
        ]);
    }

    public function processPayment($counselorId, $scheduleIds)
    {
        $counselor = Counselor::with('user')->findOrFail($counselorId);
        $scheduleIdArray = explode(',', $scheduleIds);
        $schedules = $counselor->schedules()->whereIn('id', $scheduleIdArray)->get();

        return Inertia::render('Counselor/BookingConfirmation', [
            'counselor' => $counselor,
            'schedules' => $schedules,
        ]);
    }
}
