<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $counselorId = Auth::user()->counselor->id;

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        // Bookings Today
        $todayBookings = Booking::where('counselor_id', $counselorId)
            ->whereDate('created_at', $today)
            ->count();

        // Bookings This Week
        $weeklyBookings = Booking::where('counselor_id', $counselorId)
            ->whereBetween('created_at', [$weekStart, now()])
            ->count();

        // Bookings This Month
        $monthlyBookings = Booking::where('counselor_id', $counselorId)
            ->whereBetween('created_at', [$monthStart, now()])
            ->count();

        // Completed Bookings
        $completedBookings = Booking::where('counselor_id', $counselorId)
            ->where('status', 'completed')
            ->count();

        // Total Income (successful payments only)
        $totalIncome = Payment::whereHas('booking', function ($query) use ($counselorId) {
                $query->where('counselor_id', $counselorId);
            })
            ->where('status', 'success')
            ->sum('amount');

        // ============================
        // RECENT ORDERS (Table)
        // ============================

        $recentBookings = Booking::with(['client', 'payment'])
            ->where('counselor_id', $counselorId)
            ->latest()
            ->limit(5)
            ->get();


        // ============================
        // CHART DATA
        // ============================

        $incomeByMonth = Payment::where('status', 'success')
            ->whereHas('booking', function ($q) use ($counselorId) {
                $q->where('counselor_id', $counselorId);
            })
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartIncome[] = $incomeByMonth[$i] ?? 0;
        }


        return view('counselor.dashboard.dashboard', [
            'todayBookings'      => $todayBookings,
            'weeklyBookings'     => $weeklyBookings,
            'monthlyBookings'    => $monthlyBookings,
            'completedBookings'  => $completedBookings,
            'totalIncome'        => $totalIncome,
            'recentBookings'     => $recentBookings,
            'chartIncome'        => $chartIncome,
        ]);
    }
}
