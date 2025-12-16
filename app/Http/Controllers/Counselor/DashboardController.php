<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $counselorId = Auth::user()->counselor->id;

        $data = $this->dashboardService->getCounselorDashboardData($counselorId);

        // Add booking stats for counselor-specific cards
        $bookingStats = $this->dashboardService->getBookingStats($counselorId);

        return view('counselor.dashboard.dashboard', array_merge($data, [
            'todayBookings'      => $bookingStats['today'],
            'weeklyBookings'     => $bookingStats['weekly'],
            'monthlyBookings'    => $bookingStats['monthly'],
            'completedBookings'  => $bookingStats['completed'],
            'totalIncome'        => $data['filteredRevenue'],
            'totalClients'       => 0, // Not applicable for counselor
            'filterMonth'        => $data['filterMonth'] ?? now()->month,
            'filterYear'         => $data['filterYear'] ?? now()->year,
        ]));
    }
}
