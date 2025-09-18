<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property\FavoritePropertyResource;
use App\Repositories\FavoritePropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritePropertyController extends Controller
{
    protected $favoritePropertyRepository;

    public function __construct(FavoritePropertyRepositoryInterface $favoritePropertyRepository)
    {
        $this->favoritePropertyRepository = $favoritePropertyRepository;
    }

    /**
     * ## Get User's Favorite Properties
     *
     * Retrieves the list of properties that the authenticated user has marked as favorite.
     *
     * @return JsonResponse Returns a JSON response with the user's favorite properties.
     */
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $favorites = $this->favoritePropertyRepository->getUserFavorites($userId);

        return new JsonResponse([
            'success' => true,
            'properties' => FavoritePropertyResource::collection($favorites)
        ]);
    }

    /**
     * ## Toggle Favorite Property
     *
     * Adds a property to the authenticated user's favorites if it is not already added.
     * If the property is already in favorites, it will be removed instead.
     *
     * @param int $propertyId The ID of the property to be toggled in favorites.
     * @return JsonResponse Returns a JSON response indicating whether the property was added or removed.
     */
    public function addOrRemove($propertyId): JsonResponse
    {
        $userId = Auth::id();
        $existingFavorite = $this->favoritePropertyRepository->isUserFavorite($userId, $propertyId);

        if ($existingFavorite) {
            $this->favoritePropertyRepository->removeAlreadyExistsProperty($userId, $propertyId);
            return new JsonResponse([
                'message' => 'Property removed from favorites',
            ], 200);
        }

        $favorite = $this->favoritePropertyRepository->addToFavorites($userId, $propertyId);

        return new  JsonResponse([
            'message' => 'Property added to favorites',
            'data' => $favorite
        ], 201);
    }

    /**
     * ## Check if Property is Favorited
     *
     * Determines whether the authenticated user has added the given property to their favorites.
     *
     * @param int $propertyId The ID of the property to check.
     * @return JsonResponse Returns a JSON response with a boolean value indicating whether the property is favorited.
     */
    public function isFavorite($propertyId): JsonResponse
    {
        $isFavorite = $this->favoritePropertyRepository->isUserFavorite(Auth::id(), $propertyId);

        return new JsonResponse(['isFavorite' => $isFavorite]);
    }

    /**
     * ## Remove Property from Favorites
     *
     * Deletes a property from the authenticated user's favorite list.
     *
     * @param int $propertyId The ID of the property to be removed.
     *
     * @return JsonResponse Returns a JSON response confirming the removal.
     */
    public function destroy($favoritePropertyId): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            return new JsonResponse([
                'message' => 'Unauthorized: User not authenticated',
            ], 401);
        }

        $deleted = $this->favoritePropertyRepository->removeFromFavorites($userId, (int) $favoritePropertyId);

        if ($deleted) {
            return new JsonResponse([
                'message' => 'Property removed from favorites',
            ], 200);
        }

        return new JsonResponse([
            'message' => 'Favorite not found or could not be removed',
        ], 404);
    }
}
