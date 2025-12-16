<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselorRequest;
use App\Http\Requests\UpdateCounselorRequest;
use App\Models\Counselor;
use App\Services\CounselorService;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class CounselorController extends Controller
{

    protected $counselorService;
    protected $dashboardService;

    public function __construct(CounselorService $counselorService, DashboardService $dashboardService)
    {
        $this->counselorService = $counselorService;
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $counselors = Counselor::with('user')->get();
        return view('admin.counselor.index', [
            'counselors' => $counselors
        ]);
    }

    public function create()
    {
        return view('admin.counselor.create');
    }

    public function store(StoreCounselorRequest $request)
    {
        try {
            $counselor = $this->counselorService->create($request->validated());
        return redirect()
            ->route('admin.counselor.index')
            ->with('success', 'Counselor created successfully!');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create counselor: ' . $th->getMessage());
        }

    }

    public function edit(Counselor $counselor){
        return view('admin.counselor.edit', ['counselor' => $counselor]);
    }

    public function update(UpdateCounselorRequest $request, Counselor $counselor){
        try {
            $this->counselorService->update($counselor, $request->validated());

            return redirect()
                ->route('admin.counselor.index')
                ->with('success', 'Counselor berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data counselor: ' . $e->getMessage());
        }
    }

    public function show($counselorId)
    {
        // Get counselor detail
        $counselor = Counselor::with('user')->findOrFail($counselorId);

        // Get all dashboard data using DashboardService
        $dashboardData = $this->dashboardService->getCounselorDashboardData($counselor->id);

        // Return view with counselor and dashboard data
        return view('admin.counselor.detail', array_merge(
            ['counselor' => $counselor],
            $dashboardData
        ));
    }


}
