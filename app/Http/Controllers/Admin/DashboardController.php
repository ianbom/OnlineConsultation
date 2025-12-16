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
    public function index(Request $request)
{
    $today = Carbon::today();
    $weekStart = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    // Get filter parameters
    $filterType = $request->get('filter_type', 'all'); // all, last7days, month, year
    $filterMonth = $request->get('filter_month', Carbon::now()->month);
    $filterYear = $request->get('filter_year', Carbon::now()->year);

    /* ===============================
     * CLIENTS
     * =============================== */
    $totalClients = \App\Models\User::where('role', 'client')->count();

    /* ===============================
     * FILTERED BOOKINGS & REVENUE
     * =============================== */
    $bookingQuery = Booking::query();
    $paymentQuery = Payment::where('status', 'success');

    switch ($filterType) {
        case 'last7days':
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $bookingQuery->where('created_at', '>=', $startDate);
            $paymentQuery->where('created_at', '>=', $startDate);
            break;
        case 'month':
            $bookingQuery->whereYear('created_at', $filterYear)
                        ->whereMonth('created_at', $filterMonth);
            $paymentQuery->whereYear('created_at', $filterYear)
                        ->whereMonth('created_at', $filterMonth);
            break;
        case 'year':
            $bookingQuery->whereYear('created_at', $filterYear);
            $paymentQuery->whereYear('created_at', $filterYear);
            break;
    }

    $filteredBookings = $bookingQuery->count();
    $filteredRevenue = $paymentQuery->sum('amount');

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
     * CHART: INCOME PER MONTH (Current Year)
     * =============================== */
    $currentYear = Carbon::now()->year;
    $incomeByMonth = Payment::where('status', 'success')
        ->whereYear('created_at', $currentYear)
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $chartIncome = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartIncome[] = $incomeByMonth[$i] ?? 0;
    }

    /* ===============================
     * CHART: BOOKINGS PER MONTH (Current Year)
     * =============================== */
    $bookingsByMonth = Booking::whereYear('created_at', $currentYear)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $chartBookings = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartBookings[] = $bookingsByMonth[$i] ?? 0;
    }

    return view('admin.dashboard.dashboard', [
        // Clients
        'totalClients'        => $totalClients,

        // Filtered Stats
        'filteredBookings'    => $filteredBookings,
        'filteredRevenue'     => $filteredRevenue,
        'filterType'          => $filterType,
        'filterMonth'         => $filterMonth,
        'filterYear'          => $filterYear,

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

        // Chart Income
        'chartIncome'         => $chartIncome,

        // Chart Bookings
        'chartBookings'       => $chartBookings,
    ]);
}
}
