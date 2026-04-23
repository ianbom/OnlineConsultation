<?php

use App\Models\Counselor;
use App\Models\CounselorsWorkDay;
use App\Models\Schedule;
use App\Models\User;

test('booking requires notes', function () {
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

    $schedule = Schedule::create([
        'workday_id' => $workday->id,
        'counselor_id' => $counselor->id,
        'date' => now()->addDays(3)->toDateString(),
        'start_time' => '09:00',
        'end_time' => '10:00',
        'is_available' => true,
    ]);

    $response = $this
        ->actingAs($client)
        ->from(route('client.process.payment', [
            'counselorId' => $counselor->id,
            'scheduleIds' => $schedule->id,
        ]))
        ->post(route('client.book.schedule', $counselor->id), [
            'schedule_id' => $schedule->id,
            'consultation_type' => 'online',
            'notes' => '',
        ]);

    $response->assertRedirect(route('client.process.payment', [
        'counselorId' => $counselor->id,
        'scheduleIds' => $schedule->id,
    ]));
    $response->assertSessionHasErrors('notes');
});
