<?php

namespace App\Repositories\Eloquent;

use App\Models\Property;
use App\Repositories\AppPropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AppPropertyRepository implements AppPropertyRepositoryInterface
{
    /**
     * ## Get Featured Properties
     * Retrieves the latest `is_featured` properties, limiting the result.
     *
     * @param int $limit The number of properties to return
     * @return Collection The collection of featured properties
     */
    public function getFeaturedProperties(int $limit): Collection
    {
        return Property::where('is_featured', 1)
            ->latest()
            ->take($limit)
            ->get();
    }
}
