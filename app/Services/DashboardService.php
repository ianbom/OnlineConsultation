<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;

class DashboardService
{

    public function getTotalClients(): int
    {
        return User::where('role', 'client')->count();
    }


    public function getCounselorStats(): array
    {
        return [
            'total' => Counselor::count(),
            'active' => Counselor::where('status', 'active')->count(),
            'inactive' => Counselor::where('status', 'inactive')->count(),
        ];
    }


    public function getBookingStats(): array
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        return [
            'total' => Booking::count(),
            'today' => Booking::whereDate('created_at', $today)->count(),
            'weekly' => Booking::whereBetween('created_at', [$weekStart, now()])->count(),
            'monthly' => Booking::whereBetween('created_at', [$monthStart, now()])->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rescheduled' => Booking::where('status', 'rescheduled')->count(),
            'paid' => Booking::where('status', 'paid')->count(),
        ];
    }

    /**
     * Get filtered bookings and revenue based on filter type
     */
    public function getFilteredStats(string $filterType, int $filterMonth, int $filterYear): array
    {
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

        return [
            'bookings' => $bookingQuery->count(),
            'revenue' => $paymentQuery->sum('amount'),
        ];
    }

    /**
     * Get schedule statistics
     */
    public function getScheduleStats(): array
    {
        return [
            'total' => Schedule::count(),
            'available' => Schedule::where('is_available', true)->count(),
            'unavailable' => Schedule::where('is_available', false)->count(),
        ];
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats(): array
    {
        return [
            'totalIncome' => Payment::where('status', 'success')->sum('amount'),
            'totalRefund' => Payment::whereIn('status', ['refund', 'refunded'])->sum('refund_amount'),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
        ];
    }

    /**
     * Get recent bookings
     */
    public function getRecentBookings(int $limit = 5)
    {
        return Booking::with([
                'client',
                'counselor.user',
                'payment'
            ])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent payments
     */
    public function getRecentPayments(int $limit = 10)
    {
        return Payment::with([
                'booking.client',
                'booking.counselor.user'
            ])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get monthly income chart data for current year
     */
    public function getMonthlyIncomeChart(): array
    {
        $currentYear = Carbon::now()->year;
        $incomeByMonth = Payment::where('status', 'success')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $incomeByMonth[$i] ?? 0;
        }

        return $chartData;
    }

    /**
     * Get monthly bookings chart data for current year
     */
    public function getMonthlyBookingsChart(): array
    {
        $currentYear = Carbon::now()->year;
        $bookingsByMonth = Booking::whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $bookingsByMonth[$i] ?? 0;
        }

        return $chartData;
    }

    /**
     * Get all dashboard data (only data used in admin dashboard view)
     */
    public function getDashboardData(string $filterType = 'all', ?int $filterMonth = null, ?int $filterYear = null): array
    {
        $filterMonth = $filterMonth ?? Carbon::now()->month;
        $filterYear = $filterYear ?? Carbon::now()->year;

        $filteredStats = $this->getFilteredStats($filterType, $filterMonth, $filterYear);

        return [
            // Main Statistics
            'totalClients' => $this->getTotalClients(),
            'filteredBookings' => $filteredStats['bookings'],
            'filteredRevenue' => $filteredStats['revenue'],

            // Filter Parameters
            'filterType' => $filterType,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear,

            // Recent Data
            'recentBookings' => $this->getRecentBookings(),

            // Charts
            'chartIncome' => $this->getMonthlyIncomeChart(),
            'chartBookings' => $this->getMonthlyBookingsChart(),
        ];
    }
}
