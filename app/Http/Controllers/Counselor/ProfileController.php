<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCounselorProfileRequest;
use App\Services\CounselorProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    protected $counselorProfileService;

    public function __construct(CounselorProfileService $counselorProfileService)
    {
        $this->counselorProfileService = $counselorProfileService;
     }


    public function index()
    {
        $profile = Auth::user();
        return view('counselor.profile.index', ['profile' => $profile]);
    }

    public function update(UpdateCounselorProfileRequest $request)
    {
        $user = Auth::user();

        try {
        $this->counselorProfileService->update($user, $request->validated());
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $th->getMessage());
        }

    }
}
