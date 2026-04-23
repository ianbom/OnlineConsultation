<?php

use App\Models\Booking;
use App\Models\Counselor;
use App\Models\CounselorsWorkDay;
use App\Models\Schedule;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;

test('admin can export bookings by schedule date range', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $client = User::factory()->create([
        'role' => 'client',
        'email_verified_at' => now(),
    ]);

    $counselorUser = User::factory()->create([
        'role' => 'counselor',
        'email_verified_at' => now(),
    ]);

    $counselor = Counselor::create([
        'user_id' => $counselorUser->id,
        'education' => 'S.Psi',
        'specialization' => 'Anxiety',
        'description' => 'Counselor description',
        'price_per_session' => 100000,
        'online_price_per_session' => 90000,
        'status' => 'active',
    ]);

    $workday = CounselorsWorkDay::create([
        'counselor_id' => $counselor->id,
        'day_of_week' => 'monday',
        'start_time' => '09:00',
        'end_time' => '17:00',
        'is_active' => true,
    ]);

    $inRangeSchedule = Schedule::create([
        'workday_id' => $workday->id,
        'counselor_id' => $counselor->id,
        'date' => '2026-04-10',
        'start_time' => '09:00',
        'end_time' => '10:00',
        'is_available' => false,
    ]);

    $outOfRangeSchedule = Schedule::create([
        'workday_id' => $workday->id,
        'counselor_id' => $counselor->id,
        'date' => '2026-05-10',
        'start_time' => '11:00',
        'end_time' => '12:00',
        'is_available' => false,
    ]);

    Booking::create([
        'client_id' => $client->id,
        'counselor_id' => $counselor->id,
        'schedule_id' => $inRangeSchedule->id,
        'price' => 100000,
        'duration_hours' => 1,
        'consultation_type' => 'online',
        'notes' => 'Keluhan dalam rentang',
        'status' => 'paid',
    ]);

    Booking::create([
        'client_id' => $client->id,
        'counselor_id' => $counselor->id,
        'schedule_id' => $outOfRangeSchedule->id,
        'price' => 100000,
        'duration_hours' => 1,
        'consultation_type' => 'offline',
        'notes' => 'Keluhan di luar rentang',
        'status' => 'completed',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.booking.export', [
            'export' => 'range',
            'date_from' => '2026-04-01',
            'date_to' => '2026-04-30',
        ]));

    $response->assertOk();
    $response->assertHeader('content-disposition');
    expect($response->headers->get('content-type'))->toContain('spreadsheetml');

    $tempFile = tempnam(sys_get_temp_dir(), 'booking-export');
    $xlsxFile = $tempFile . '.xlsx';
    rename($tempFile, $xlsxFile);

    file_put_contents($xlsxFile, $response->streamedContent());

    $spreadsheet = IOFactory::load($xlsxFile);
    $rows = $spreadsheet->getActiveSheet()->toArray();
    $flatRows = collect($rows)
        ->flatten()
        ->filter(fn ($value) => filled($value))
        ->values()
        ->all();

    expect($flatRows)->toContain('Keluhan dalam rentang');
    expect($flatRows)->not->toContain('Keluhan di luar rentang');

    @unlink($xlsxFile);
});
