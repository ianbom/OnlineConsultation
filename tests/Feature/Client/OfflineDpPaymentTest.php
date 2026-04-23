<?php

use App\Http\Controllers\Client\PaymentController;
use App\Models\Booking;
use App\Models\Counselor;
use App\Models\CounselorsWorkDay;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;

test('offline dp booking stores down payment and remaining amount', function () {
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

    $booking = app(BookingService::class)->createBooking(
        $client,
        $counselor->id,
        $schedule->id,
        null,
        'Keluhan offline',
        'offline',
        'dp',
    );

    expect($booking->price)->toBe(100000);
    expect($booking->payment_scheme)->toBe('dp');
    expect($booking->down_payment_percentage)->toBe(50);
    expect($booking->down_payment_amount)->toBe(50000);
    expect($booking->remaining_amount)->toBe(50000);
    expect($booking->status)->toBe('pending_payment');
});

test('successful dp settlement marks booking as dp_paid and payment as partial', function () {
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
        'is_available' => false,
    ]);

    $booking = Booking::create([
        'client_id' => $client->id,
        'counselor_id' => $counselor->id,
        'schedule_id' => $schedule->id,
        'price' => 100000,
        'duration_hours' => 1,
        'consultation_type' => 'offline',
        'payment_scheme' => 'dp',
        'down_payment_percentage' => 50,
        'down_payment_amount' => 50000,
        'remaining_amount' => 50000,
        'notes' => 'Keluhan offline',
        'status' => 'pending_payment',
    ]);

    $payment = Payment::create([
        'booking_id' => $booking->id,
        'amount' => 50000,
        'order_id' => 'ORDER-DP-1',
        'status' => 'pending',
    ]);

    [$updatedBooking, $updatedPayment] = PaymentController::applyStatus(
        $booking,
        $payment,
        'settlement',
        null,
        new Request(),
    );

    expect($updatedBooking->status)->toBe('dp_paid');
    expect($updatedPayment->status)->toBe('partial');
});
