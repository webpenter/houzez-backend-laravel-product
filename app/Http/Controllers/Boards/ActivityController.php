<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Resources\Activity\ReviewResource;
use App\Models\Review;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use ResponseTrait;
    /**
     * Get all reviews of the logged-in user.
     *
     * @return JsonResponse
     */
    public function myReviews(): JsonResponse
    {
        $userId = auth()->id();

        $reviews = Review::where('user_id', $userId)
            ->with('property')
            ->latest()
            ->take(10)
            ->get();

        return $this->successResponse(ReviewResource::collection($reviews), 'User reviews fetched successfully.');
    }
}
