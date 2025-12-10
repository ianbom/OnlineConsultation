<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientProfileRequest;
use App\Services\ClientProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    protected $clientProfileService;

    public function __construct(ClientProfileService $clientProfileService)
    {
        $this->clientProfileService = $clientProfileService;
    }

    public function myProfile()
    {
        $user = Auth::user();

        return Inertia::render('Profile/ClientProfile', ['user' => $user]);
    }

    public function updateProfile(UpdateClientProfileRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        try {
            $updatedUser = $this->clientProfileService->update($user, $data);
            return redirect()->back()->with('success', 'Profile berhasil diubah');
        } catch (\Throwable $th) {
           return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' );
        }

    }
}
