<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\Others\StoreReviewRequest;
use App\Http\Resources\Others\ReviewResource;
use App\Repositories\ReviewRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Store a new review.
     * @return JsonResponse
     */
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $this->reviewRepository->create([
            'property_id' => $request->property_id,
            'user_id' => auth()->id(),
            'email' => $request->email,
            'title' => $request->title,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(new ReviewResource($review), 201);
    }

    /**
     * Fetch reviews for a specific property.
     * @return JsonResponse
     */
    public function show(int $propertyId): JsonResponse
    {
        $reviews = $this->reviewRepository->getReviewsByProperty($propertyId);
        return response()->json(ReviewResource::collection($reviews));
    }
}
