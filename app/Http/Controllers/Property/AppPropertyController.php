<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property\FeaturedPropertyResource;
use App\Repositories\AppPropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
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
            'properties' => FeaturedPropertyResource::collection($properties),
        ]);
    }
}
