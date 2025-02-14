<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
interface AppPropertyRepositoryInterface
{
    /**
     * ## Get Featured Properties
     * Fetch the latest featured properties limited by a given number.
     *
     * @param int $limit Number of properties to fetch
     * @return Collection The collection of featured properties
     */
    public function getFeaturedProperties(int $limit): Collection;
}
