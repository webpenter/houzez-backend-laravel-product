<?php

namespace App\Repositories;

use App\Models\Review;

interface ReviewRepositoryInterface
{
    public function create(array $data): Review;

    public function getReviewsByProperty(int $propertyId);
}
