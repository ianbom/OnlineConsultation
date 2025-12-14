<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Payment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $today = Carbon::today();
    $weekStart = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    /* ===============================
     * COUNSELOR
     * =============================== */
    $totalCounselors = Counselor::count();
    $activeCounselors = Counselor::where('status', 'active')->count();
    $inactiveCounselors = Counselor::where('status', 'inactive')->count();

    /* ===============================
     * BOOKINGS
     * =============================== */
    $totalBookings = Booking::count();

    $todayBookings = Booking::whereDate('created_at', $today)->count();

    $weeklyBookings = Booking::whereBetween('created_at', [
        $weekStart, now()
    ])->count();

    $monthlyBookings = Booking::whereBetween('created_at', [
        $monthStart, now()
    ])->count();

    $completedBookings = Booking::where('status', 'completed')->count();
    $cancelledBookings = Booking::where('status', 'cancelled')->count();
    $rescheduledBookings = Booking::where('status', 'rescheduled')->count();
    $paidBookings = Booking::where('status', 'paid')->count();

    /* ===============================
     * SCHEDULES
     * =============================== */
    $totalSchedules = Schedule::count();
    $availableSchedules = Schedule::where('is_available', true)->count();
    $unavailableSchedules = Schedule::where('is_available', false)->count();

    /* ===============================
     * PAYMENTS
     * =============================== */
    $totalIncome = Payment::where('status', 'success')->sum('amount');

    $totalRefund = Payment::whereIn('status', ['refund', 'refunded'])
        ->sum('refund_amount');

    $pendingPayments = Payment::where('status', 'pending')->count();
    $failedPayments = Payment::where('status', 'failed')->count();

    /* ===============================
     * RECENT DATA
     * =============================== */
    $recentBookings = Booking::with([
            'client',
            'counselor.user',
            'payment'
        ])
        ->latest()
        ->limit(10)
        ->get();

    $recentPayments = Payment::with([
            'booking.client',
            'booking.counselor.user'
        ])
        ->latest()
        ->limit(10)
        ->get();

    /* ===============================
     * CHART: INCOME PER MONTH
     * =============================== */
    $incomeByMonth = Payment::where('status', 'success')
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $chartIncome = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartIncome[] = $incomeByMonth[$i] ?? 0;
    }

    return view('admin.dashboard.dashboard', [
        // Counselor
        'totalCounselors'     => $totalCounselors,
        'activeCounselors'    => $activeCounselors,
        'inactiveCounselors'  => $inactiveCounselors,

        // Booking
        'totalBookings'       => $totalBookings,
        'todayBookings'       => $todayBookings,
        'weeklyBookings'      => $weeklyBookings,
        'monthlyBookings'     => $monthlyBookings,
        'completedBookings'   => $completedBookings,
        'cancelledBookings'   => $cancelledBookings,
        'rescheduledBookings' => $rescheduledBookings,
        'paidBookings'        => $paidBookings,

        // Schedule
        'totalSchedules'      => $totalSchedules,
        'availableSchedules'  => $availableSchedules,
        'unavailableSchedules'=> $unavailableSchedules,

        // Payment
        'totalIncome'         => $totalIncome,
        'totalRefund'         => $totalRefund,
        'pendingPayments'     => $pendingPayments,
        'failedPayments'      => $failedPayments,

        // Lists
        'recentBookings'      => $recentBookings,
        'recentPayments'      => $recentPayments,

        // Chart
        'chartIncome'         => $chartIncome,
    ]);
}
}
