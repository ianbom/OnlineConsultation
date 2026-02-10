<?php

namespace App\Services;

use App\Models\CounselorsWorkDay;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class CounselorWorkDayService
{
    public function __construct()
    {
        //
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $workday = CounselorsWorkDay::create([
                'counselor_id' => $data['counselor_id'],
                'day_of_week'  => $data['day_of_week'],
                'start_time'   => $data['start_time'],
                'end_time'     => $data['end_time'],
                'is_active'    => $data['is_active'] ?? true,
            ]);

            $this->generateSchedules($workday);

            return $workday;
        });
    }

    public function update(CounselorsWorkDay $workday, array $data)
    {
        return DB::transaction(function () use ($workday, $data) {
            $shouldRegenerate = (
                $workday->day_of_week !== $data['day_of_week'] ||
                $workday->start_time  !== $data['start_time'] ||
                $workday->end_time    !== $data['end_time']
            );

            $workday->update([
                'counselor_id' => $data['counselor_id'],
                'day_of_week'  => $data['day_of_week'],
                'start_time'   => $data['start_time'],
                'end_time'     => $data['end_time'],
                'is_active'    => $data['is_active'] ?? $workday->is_active,
            ]);

            if ($shouldRegenerate) {
                Schedule::where('counselor_id', $workday->counselor_id)
                    ->where('date', '>=', now()->toDateString())
                    ->delete();

                $this->generateSchedules($workday);
            }

            return $workday;
        });
    }

    private function generateSchedules(CounselorsWorkDay $workday)
    {
        $startDate = Carbon::today();
        $endDate   = Carbon::today()->addWeek();
        $period    = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            if ($date->format('l') !== ucfirst($workday->day_of_week)) {
                continue;
            }

            $this->generateHourlySlots(
                $workday->id,
                $workday->counselor_id,
                $date->toDateString(),
                $workday->start_time,
                $workday->end_time,
                $workday->is_active
            );
        }
    }

    private function generateHourlySlots($workdayId, $counselorId, $date, $start, $end, $isActive)
    {
        $startTime = Carbon::parse($start);
        $endTime   = Carbon::parse($end);

        while ($startTime < $endTime) {
            $slotEnd = (clone $startTime)->addHour();

            if ($slotEnd > $endTime) break;

            Schedule::create([
                'workday_id'   => $workdayId,
                'counselor_id' => $counselorId,
                'date'         => $date,
                'start_time'   => $startTime->format('H:i'),
                'end_time'     => $slotEnd->format('H:i'),
                'is_available' => $isActive,
            ]);

            $startTime->addHour();
        }
    }
}

