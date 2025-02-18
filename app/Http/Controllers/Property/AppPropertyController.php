<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property\AppPropertyCardResource;
use App\Repositories\AppPropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AppPropertyController extends Controller
{
    protected AppPropertyRepositoryInterface $propertyRepository;

    /**
     * ## Constructor
     * Injects the PropertyRepositoryInterface.
     *
     * @param AppPropertyRepositoryInterface $propertyRepository The property repository instance
     */
    public function __construct(AppPropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * ## Get Featured Properties
     * Fetches the latest 3 featured properties and returns them as a JSON response.
     *
     * @return JsonResponse A JSON response containing the featured properties
     */
    public function getFeaturedProperties(): JsonResponse
    {
        $properties = $this->propertyRepository->getFeaturedProperties(3);

        return response()->json([
            'success' => true,
            'properties' => AppPropertyCardResource::collection($properties),
        ]);
    }

    /**
     * ## Get searched and filtered properties.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSearchedAndFilteredProperties(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $propertyTypes = $request->get('propertyTypes');
        $city = $request->get('city');
        $maxBedrooms = $request->get('maxBedrooms');
        $maxPrice = $request->get('maxPrice');

        $properties = $this->propertyRepository->getFilteredProperties(
            $search,
            !empty($propertyTypes) ? (array) $propertyTypes : null,
            $city,
            $maxBedrooms !== 'any' ? (int) $maxBedrooms : null,
            $maxPrice !== 'any' ? (float) $maxPrice : null
        );

        return response()->json([
            'success' => true,
            'properties' => AppPropertyCardResource::collection($properties),
        ]);
    }
}
