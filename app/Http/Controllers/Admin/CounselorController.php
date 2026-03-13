<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselorRequest;
use App\Http\Requests\UpdateCounselorRequest;
use App\Models\Counselor;
use App\Services\CounselorService;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('admin.counselor.index', ['counselors' => $counselors]);
    }

    public function create()
    {
        return view('admin.counselor.create');
    }

    public function store(StoreCounselorRequest $request)
    {
        try {
            $this->counselorService->create($request->validated());
            return redirect()->route('admin.counselor.index')
                ->with('success', 'Counselor created successfully!');
        } catch (\Throwable $th) {
            Log::error('Create counselor failed: ' . $th->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Failed to create counselor: ' . $th->getMessage());
        }
    }

    public function edit(Counselor $counselor)
    {
        return view('admin.counselor.edit', ['counselor' => $counselor]);
    }

    public function update(UpdateCounselorRequest $request, Counselor $counselor)
    {
        try {
            $this->counselorService->update($counselor, $request->validated());
            return redirect()->route('admin.counselor.index')
                ->with('success', 'Counselor berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Update counselor failed: ' . $th->getMessage());
            return back()->with('error', 'Gagal memperbarui data counselor: ' . $th->getMessage());
        }
    }

    public function show(Request $request, $counselorId)
    {
        $counselor = Counselor::with('user')->findOrFail($counselorId);
        $dashboardData = $this->dashboardService->getCounselorDashboardData($counselor->id);

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $allowedSorts = ['rating', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'desc';

        $ratings = \App\Models\RatingCounselor::where('counselor_id', $counselor->user->id)
            ->with(['booking.client'])
            ->orderBy($sortBy, $sortDir)
            ->paginate(5, ['*'], 'ratings_page')
            ->withQueryString();

        return view('admin.counselor.detail', array_merge(
            [
                'counselor' => $counselor,
                'ratings' => $ratings,
                'ratingsSortBy' => $sortBy,
                'ratingsSortDir' => $sortDir,
            ],
            $dashboardData
        ));
    }
}

