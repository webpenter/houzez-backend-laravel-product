<?php

namespace App\Repositories\Eloquent;

use App\Models\FavoriteProperty;
use App\Repositories\FavoritePropertyRepositoryInterface;
use Illuminate\Support\Collection;

class FavoritePropertyRepository implements FavoritePropertyRepositoryInterface
{
    /**
     * Get a list of user's favorite properties
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserFavorites(int $userId): Collection
    {
        return FavoriteProperty::query()
            ->whereUserId($userId)
            ->with(['property' => function ($query) {
                $query->with(['images' => function ($imageQuery) {
                    $imageQuery->where('is_thumbnail', 1);
                }]);
            }])->get();
    }

    /**
     * Add a property to favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return FavoriteProperty
     */
    public function addToFavorites(int $userId, int $propertyId): FavoriteProperty
    {
        return FavoriteProperty::firstOrCreate([
            'user_id' => $userId,
            'property_id' => $propertyId,
        ]);
    }

    /**
     * Remove a property from favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool
     */
    public function removeFromFavorites(int $userId, int $propertyId): bool
    {
        return FavoriteProperty::query()
                ->whereUserId($userId)
                ->whereId($propertyId)
                ->delete() > 0;
    }

    /**
     * Remove an already exists property from favorites
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool
     */
    public function removeAlreadyExistsProperty(int $userId, int $propertyId): bool
    {
        return FavoriteProperty::query()
            ->whereUserId($userId)
            ->where('property_id', $propertyId)
            ->delete();
    }

    /**
     * Checks if the user has already marked the property as a favorite.
     *
     * @param int $userId
     * @param int $propertyId
     * @return bool Returns true if the property is already favorite, false otherwise.
     */
    public function isUserFavorite(int $userId, int $propertyId): bool
    {
        return FavoriteProperty::query()
            ->whereUserId($userId)
            ->where('property_id', $propertyId)
            ->exists();
    }
}
