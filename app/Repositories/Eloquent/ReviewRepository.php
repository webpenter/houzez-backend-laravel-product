<?php

namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * Create a new review.
     */
    public function create(array $data): Review
    {
        return Review::create($data);
    }

    /**
     * Get all reviews for a specific property.
     */
    public function getReviewsByProperty(int $propertyId)
    {
        return Review::where('property_id', $propertyId)->latest()->get();
    }
}
