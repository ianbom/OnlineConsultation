<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Services\RatingService;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(CreateRatingRequest $request)
    {
        try {
            $this->ratingService->createRating($request->validated());

            return back()->with('success', 'Rating berhasil diberikan. Terima kasih!');
        } catch (\Throwable $th) {
            Log::error('Create rating failed: ' . $th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(UpdateRatingRequest $request, $ratingId)
    {
        try {
            $this->ratingService->updateRating($ratingId, $request->validated());

            return back()->with('success', 'Rating berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Update rating failed: ' . $th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }
}
