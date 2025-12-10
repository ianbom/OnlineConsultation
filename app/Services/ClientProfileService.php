<?php

namespace App\Services;

use App\Models\User;

class ClientProfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, array $data)
    {
        if (isset($data['profile_pic'])) {
            $data['profile_pic'] = $data['profile_pic']->store('profile_pics', 'public');
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
    }
}
