<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CounselorProfileService
{
    public function __construct()
    {
        //
    }

    public function update(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            if (isset($data['profile_pic']) && !empty($data['profile_pic'])) {
                if (is_string($data['profile_pic']) && strpos($data['profile_pic'], 'data:image') === 0) {
                    if ($user->profile_pic) {
                        Storage::disk('public')->delete($user->profile_pic);
                    }

                    preg_match('/data:image\/(\w+);base64,(.*)/', $data['profile_pic'], $matches);
                    $imageType = $matches[1] ?? 'jpg';
                    $imageData = $matches[2] ?? '';

                    $filename = 'profile_pics/' . uniqid() . '_' . time() . '.' . $imageType;
                    Storage::disk('public')->put($filename, base64_decode($imageData));

                    $data['profile_pic'] = $filename;
                } elseif (is_object($data['profile_pic']) && method_exists($data['profile_pic'], 'store')) {
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

            $user->counselor()->update([
                'education'      => $data['education'],
                'specialization' => $data['specialization'],
                'description'    => $data['description'],
            ]);

            return $user->fresh();
        });
    }
}
