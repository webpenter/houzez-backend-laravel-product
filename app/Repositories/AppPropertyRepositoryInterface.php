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

    /**
     * ## Get filtered properties based on search criteria.
     *
     * @param string|null $search The search query to filter properties by title.
     * @param array|null $propertyTypes The array of property types to filter.
     * @param string|null $city The city to filter properties by.
     * @param int|null $maxBedrooms The maximum number of bedrooms to filter.
     * @param float|null $maxPrice The maximum price to filter.
     * @return Collection A collection of filtered properties.
     */
    public function getFilteredProperties(
        ?string $search,
        ?array $propertyTypes,
        ?string $city,
        ?int $maxBedrooms,
        ?float $maxPrice
    ): Collection;
}
