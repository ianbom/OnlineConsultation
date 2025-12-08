<?php

namespace App\Services;

use App\Models\User;

class CounselorProfileService
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
        // Handle Profile Picture Upload
        if (isset($data['profile_pic'])) {
            $data['profile_pic'] = $data['profile_pic']->store('profile_pics', 'public');
        }

        // Update User
        $user->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'] ?? $user->phone,
            'profile_pic' => $data['profile_pic'] ?? $user->profile_pic,
        ]);

        // Update Counselor Details
        $user->counselor()->update([
            'education'        => $data['education'],
            'specialization'   => $data['specialization'],
            'description'      => $data['description'],
            'price_per_session'=> $data['price_per_session'],
        ]);

        return $user->fresh(); // return updated data
    }
}
