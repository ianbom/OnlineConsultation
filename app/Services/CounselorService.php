<?php

namespace App\Services;

use App\Models\Counselor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CounselorService
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['profile_pic']) && $data['profile_pic']->isValid()) {
                $data['profile_pic'] = $data['profile_pic']->store('profile_pics', 'public');
            } else {
                $data['profile_pic'] = null;
            }

            $user = User::create([
                'name'        => $data['name'],
                'email'       => $data['email'],
                'password'    => Hash::make($data['password']),
                'role'        => 'counselor',
                'phone'       => $data['phone'] ?? null,
                'profile_pic' => $data['profile_pic'],
            ]);

            return Counselor::create([
                'user_id'                  => $user->id,
                'education'                => $data['education'],
                'specialization'           => $data['specialization'],
                'description'              => $data['description'],
                'price_per_session'        => $data['price_per_session'],
                'online_price_per_session' => $data['online_price_per_session'],
                'status'                   => 'active',
            ]);
        });
    }

    public function update($counselor, array $data)
    {
        return DB::transaction(function () use ($counselor, $data) {
            $user = $counselor->user;

            if (!empty($data['profile_pic']) && $data['profile_pic'] instanceof \Illuminate\Http\UploadedFile) {
                if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                    Storage::disk('public')->delete($user->profile_pic);
                }

                $data['profile_pic'] = $data['profile_pic']->store('profile_pics', 'public');
            } else {
                unset($data['profile_pic']);
            }

            $user->update([
                'name'        => $data['name'],
                'email'       => $data['email'],
                'phone'       => $data['phone'] ?? null,
                'profile_pic' => $data['profile_pic'] ?? $user->profile_pic,
                'password'    => !empty($data['password']) ? Hash::make($data['password']) : $user->password,
            ]);

            $counselor->update([
                'education'                => $data['education'],
                'specialization'           => $data['specialization'],
                'description'              => $data['description'],
                'price_per_session'        => $data['price_per_session'],
                'online_price_per_session' => $data['online_price_per_session'],
                'status'                   => $data['status'],
            ]);

            return $counselor;
        });
    }
}

