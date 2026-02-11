<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\RatingCounselor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingService
{
    public function createRating(array $data): RatingCounselor
    {
        return DB::transaction(function () use ($data) {
            $booking = Booking::with('counselor.user')->findOrFail($data['booking_id']);

            if ($booking->client_id !== Auth::id()) {
                throw new \Exception('Anda tidak memiliki akses ke booking ini.');
            }

            if ($booking->status !== 'completed') {
                throw new \Exception('Rating hanya dapat diberikan setelah sesi selesai.');
            }

            $existingRating = RatingCounselor::where('booking_id', $booking->id)->first();
            if ($existingRating) {
                throw new \Exception('Anda sudah memberikan rating untuk booking ini.');
            }

            return RatingCounselor::create([
                'counselor_id' => $booking->counselor->user->id,
                'booking_id' => $booking->id,
                'rating' => $data['rating'],
                'commentar' => $data['commentar'] ?? null,
            ]);
        });
    }

    public function updateRating(int $ratingId, array $data): RatingCounselor
    {
        return DB::transaction(function () use ($ratingId, $data) {
            $rating = RatingCounselor::findOrFail($ratingId);
            $booking = Booking::findOrFail($rating->booking_id);

            if ($booking->client_id !== Auth::id()) {
                throw new \Exception('Anda tidak memiliki akses untuk mengubah rating ini.');
            }

            $rating->update([
                'rating' => $data['rating'],
                'commentar' => $data['commentar'] ?? $rating->commentar,
            ]);

            return $rating->fresh();
        });
    }
}
