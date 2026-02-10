<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('admin.profile.index', ['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . Auth::id(),
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = Auth::user();

                if (!empty($request->profile_pic) && str_starts_with($request->profile_pic, 'data:image')) {
                    if ($user->profile_pic) {
                        Storage::disk('public')->delete($user->profile_pic);
                    }

                    preg_match('/data:image\/(\w+);base64,(.*)/', $request->profile_pic, $matches);
                    $imageType = $matches[1] ?? 'jpg';
                    $imageData = $matches[2] ?? '';

                    $filename = 'profile_pics/' . uniqid() . '_' . time() . '.' . $imageType;
                    Storage::disk('public')->put($filename, base64_decode($imageData));

                    $user->profile_pic = $filename;
                }

                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

                $user->name  = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->save();
            });

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Admin profile update failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }
}
