<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
{
    $clientId = Auth::id();

    $bookings = Booking::with([
            'schedule',
            'secondSchedule',
            'counselor.user',
            'payment'
        ])
        ->forClient($clientId)
        ->get()
        ->groupBy('status');

    $upcoming = $bookings['paid'] ?? collect();
    $completed = $bookings['completed'] ?? collect();
    $pendingPayment = $bookings['pending_payment'] ?? collect();

    $recentConsultations = Booking::with([
            'schedule',
            'secondSchedule',
            'counselor.user',
            'payment'
        ])
        ->forClient($clientId)
        ->recentConsultations()
        ->get();

    return Inertia::render('DashboardClient', [
        'upcomingBooking'      => $upcoming,
        'completedBooking'     => $completed,
        'pendingPaymentBooking'=> $pendingPayment,
        'recentConsultations'  => $recentConsultations,
    ]);
}

}
