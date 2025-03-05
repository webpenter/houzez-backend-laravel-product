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
     * ## Add Property to Favorites
     *
     * Adds a property to the authenticated user's favorites if it isn't already added.
     *
     * @param int $propertyId The ID of the property to be favorited.
     *
     * @return JsonResponse Returns a JSON response indicating success or failure.
     */
    public function store($propertyId): JsonResponse
    {
        $userId = Auth::id();
        $existingFavorite = $this->favoritePropertyRepository->isUserFavorite($userId, $propertyId);

        if ($existingFavorite) {
            return new JsonResponse([
                'message' => 'Already added to favorite properties',
            ], 409);
        }

        $favorite = $this->favoritePropertyRepository->addToFavorites($userId, $propertyId);

        return new  JsonResponse([
            'message' => 'Property added to favorites',
            'data' => $favorite
        ], 201);
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

        $this->favoritePropertyRepository->removeFromFavorites($userId, $favoritePropertyId);

        return new JsonResponse([
            'message' => 'Property removed from favorites',
        ]);
    }
}
