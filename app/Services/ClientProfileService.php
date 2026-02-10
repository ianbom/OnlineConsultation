<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientProfileService
{
    public function __construct()
    {
        //
    }

    public function update(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            if (isset($data['profile_pic']) && !empty($data['profile_pic'])) {
                if (is_object($data['profile_pic']) && method_exists($data['profile_pic'], 'store')) {
                    if ($user->profile_pic) {
                        Storage::disk('public')->delete($user->profile_pic);
                    }

                    $data['profile_pic'] = $data['profile_pic']->store('profile_pics', 'public');
                }
            }

            if (!empty($data['password'])) {
                $user->update([
                    'password' => bcrypt($data['password'])
                ]);
            }

            $user->update([
                'name'        => $data['name'],
                'email'       => $data['email'],
                'phone'       => $data['phone'] ?? $user->phone,
                'profile_pic' => $data['profile_pic'] ?? $user->profile_pic,
            ]);

            return $user->fresh();
        });
    }
}
