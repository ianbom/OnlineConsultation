<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        // Handle Profile Picture Upload (Base64 or File)
        if (isset($data['profile_pic']) && !empty($data['profile_pic'])) {
            // Check if it's a base64 string
            if (is_string($data['profile_pic']) && strpos($data['profile_pic'], 'data:image') === 0) {
                // Delete old profile picture if exists
                if ($user->profile_pic) {
                    Storage::disk('public')->delete($user->profile_pic);
                }

                // Extract base64 data
                preg_match('/data:image\/(\w+);base64,(.*)/', $data['profile_pic'], $matches);
                $imageType = $matches[1] ?? 'jpg';
                $imageData = $matches[2] ?? '';

                // Generate unique filename
                $filename = 'profile_pics/' . uniqid() . '_' . time() . '.' . $imageType;

                // Decode and save
                Storage::disk('public')->put($filename, base64_decode($imageData));

                $data['profile_pic'] = $filename;
            }
            // Handle regular file upload
            elseif (is_object($data['profile_pic']) && method_exists($data['profile_pic'], 'store')) {
                // Delete old profile picture if exists
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
        ]);

        return $user->fresh(); // return updated data
    }
}
