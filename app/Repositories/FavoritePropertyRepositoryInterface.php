<?php

namespace App\Repositories;

use App\Models\FavoriteProperty;
use Illuminate\Support\Collection;

interface FavoritePropertyRepositoryInterface
{
    /**
     * Get a list of user's favorite properties
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserFavorites(int $userId): Collection;

    /**
     * Add a property to favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return FavoriteProperty
     */
    public function addToFavorites(int $userId, int $propertyId): FavoriteProperty;

    /**
     * Remove a property from favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool
     */
    public function removeFromFavorites(int $userId, int $propertyId): bool;

    /**
     * Remove an already exists property from favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool
     */
    public function removeAlreadyExistsProperty(int $userId, int $propertyId): bool;

    /**
     * Checks if the user has already marked the property as a favorite.
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool Returns true if the property is already favorite, false otherwise.
     */
    public function isUserFavorite(int $userId, int $propertyId): bool;
}
