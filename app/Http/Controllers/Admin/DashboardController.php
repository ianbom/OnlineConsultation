<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        // Get filter parameters
        $filterType = $request->get('filter_type', 'all');
        $filterMonth = $request->get('filter_month');
        $filterYear = $request->get('filter_year');

        // Get all dashboard data from service
        $data = $this->dashboardService->getDashboardData(
            $filterType,
            $filterMonth,
            $filterYear
        );

        return view('admin.dashboard.dashboard', $data);
    }
}
