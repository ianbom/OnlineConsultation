<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.client.index', ['clients' => $clients]);
    }

    public function show($id)
{
    // ============================
    // CLIENT DATA
    // ============================
    $client = User::findOrFail($id);

    $today      = Carbon::today();
    $weekStart  = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    // ============================
    // BOOKING STATISTICS (BY CLIENT)
    // ============================

    $todayBookings = Booking::where('client_id', $client->id)
        ->whereDate('created_at', $today)
        ->count();

    $weeklyBookings = Booking::where('client_id', $client->id)
        ->whereBetween('created_at', [$weekStart, now()])
        ->count();

    $monthlyBookings = Booking::where('client_id', $client->id)
        ->whereBetween('created_at', [$monthStart, now()])
        ->count();

    $completedBookings = Booking::where('client_id', $client->id)
        ->where('status', 'completed')
        ->count();

    // ============================
    // TOTAL SPENDING (SUCCESS PAYMENT)
    // ============================

    $totalSpending = Payment::where('status', 'success')
        ->whereHas('booking', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->sum('amount');

    // ============================
    // RECENT BOOKINGS
    // ============================

    $recentBookings = Booking::with(['counselor.user', 'payment'])
        ->where('client_id', $client->id)
        ->latest()
        ->limit(5)
        ->get();

    // ============================
    // SPENDING CHART (PER MONTH)
    // ============================

    $spendingByMonth = Payment::where('status', 'success')
        ->whereHas('booking', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $chartSpending = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartSpending[] = $spendingByMonth[$i] ?? 0;
    }

    // ============================
    // RETURN VIEW
    // ============================


    return view('admin.client.detail', [
        'client'              => $client,
        'todayBookings'       => $todayBookings,
        'weeklyBookings'      => $weeklyBookings,
        'monthlyBookings'     => $monthlyBookings,
        'completedBookings'   => $completedBookings,
        'totalSpending'       => $totalSpending,
        'recentBookings'      => $recentBookings,
        'chartSpending'       => $chartSpending,
    ]);
}



}
