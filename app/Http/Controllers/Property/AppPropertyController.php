<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property\AppPropertiesCardResource;
use App\Http\Resources\Property\AppPropertyCardResource;
use App\Http\Resources\Property\AppPropertyDetailsResource;
use App\Http\Resources\Demos\Demo01\Property\AppPropertyCardDemo01Resource;
use App\Http\Resources\Demos\Demo01\Property\AppPropertyDetailsDemo01Resource;
use App\Repositories\AppPropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Property;
use Illuminate\Support\Facades\Session;

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
     * Fetches the latest 6 featured properties and returns them as a JSON response.
     *
     * @return JsonResponse A JSON response containing the featured properties
     */
    public function getFeaturedProperties(): JsonResponse
    {
        $properties = $this->propertyRepository->getFeaturedProperties(6);

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardResource::collection($properties),
        ]);
    }

    /**
     * ## Get Latest Properties
     * Fetches the latest 6 properties and returns them as a JSON response.
     *
     * @return JsonResponse A JSON response containing the latest properties
     */
    public function getLatestProperties(): JsonResponse
    {
        $properties = $this->propertyRepository->getLatestProperties(6);

        return new JsonResponse([
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

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardResource::collection($properties),
        ]);
    }

    /**
     * ## Fetch all properties based on filters from the request.
     *
     * @param Request $request The incoming request containing filter parameters.
     * @return JsonResponse The response containing the filtered properties.
     */
    public function getAllProperties(Request $request): JsonResponse
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

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertiesCardResource::collection($properties),
        ]);
    }

    /**
     * ## Retrieve property data by slug.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function getPropertyData(string $slug): JsonResponse
    {
        $property = $this->propertyRepository->findBySlug($slug);

        return $property
            ? new JsonResponse(['property' => new AppPropertyDetailsResource($property)])
            : response()->json(['message' => 'Property not found'], 404);
    }



    /**
     * ====================================================================================
     * ====================================================================================
     *
     * Demo01 - Property Display APIs
     *
     * ====================================================================================
     * ====================================================================================
     *
     * This section contains all the API methods specifically built for the Demo01 version
     * of the frontend, including featured properties, latest listings, and more.
     */


    /**
     * ## Get Featured Properties
     * Fetches the latest 6 featured properties and returns them as a JSON response.
     *
     * @return JsonResponse A JSON response containing the featured properties
     */
    public function getFeaturedPropertiesDemo01(): JsonResponse
    {
        $properties = $this->propertyRepository->getFeaturedProperties(6);

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardDemo01Resource::collection($properties),
        ]);
    }

    /**
     * ## Get Latest Properties
     * Fetches the latest 6 properties and returns them as a JSON response.
     *
     * @return JsonResponse A JSON response containing the latest properties
     */
    public function getLatestPropertiesDemo01(): JsonResponse
    {
        $properties = $this->propertyRepository->getLatestProperties(6);

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardDemo01Resource::collection($properties),
        ]);
    }

    /**
     * ## Retrieve property data by slug.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function getPropertyDataDemo01(string $slug): JsonResponse
    {
        $property = $this->propertyRepository->findBySlugDemo01($slug);

        return $property
            ? new JsonResponse(['property' => new AppPropertyDetailsDemo01Resource($property)])
            : response()->json(['message' => 'Property not found'], 404);
    }

    /**
     * ## Get searched and filtered properties.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSearchedAndFilteredPropertiesDemo01(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $propertyTypes = $request->get('propertyTypes');
        $cities = $request->get('cities');
        $maxBedrooms = $request->get('maxBedrooms');
        $maxPrice = $request->get('maxPrice');
        $status = $request->get('status');

        $properties = $this->propertyRepository->getFilteredPropertiesDemo01(
            $search,
            !empty($propertyTypes) ? (array) $propertyTypes : null,
            !empty($cities) ? (array) $cities : null,
            $maxBedrooms !== 'any' ? (int) $maxBedrooms : null,
            $maxPrice !== 'any' ? (float) $maxPrice : null,
            $status !== '' ? $status : null
        );

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardDemo01Resource::collection($properties),
        ]);
    }

    /**
     * ## Fetch all properties based on filters from the request.
     *
     * @param Request $request The incoming request containing filter parameters.
     * @return JsonResponse The response containing the filtered properties.
     */
    public function getAllPropertiesDemo01(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $propertyTypes = $request->get('propertyTypes');
        $cities = $request->get('city');
        $maxBedrooms = $request->get('maxBedrooms');
        $maxPrice = $request->get('maxPrice');
        $status = $request->get('status');


        $properties = $this->propertyRepository->getFilteredPropertiesDemo01(
            $search,
            !empty($propertyTypes) ? (array) $propertyTypes : null,
            !empty($cities) ? (array) $cities : null,
            $maxBedrooms !== 'any' ? (int) $maxBedrooms : null,
            $maxPrice !== 'any' ? (float) $maxPrice : null,
            $status !== '' ? $status : null
        );

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardDemo01Resource::collection($properties),
        ]);
    }

    /**
     * ## Get Property Type Data
     * Returns all published properties of a specific type as a JSON response.
     *
     * @param string $type The type of property
     * @return JsonResponse JSON response with filtered properties
     */
    public function getPropertyTypeDataDemo01(string $type): JsonResponse
    {
        $properties = $this->propertyRepository->getPropertiesByType($type);

        return new JsonResponse([
            'success' => true,
            'properties' => AppPropertyCardDemo01Resource::collection($properties),
        ]);
    }

    /**
     * Auto-search based on input characters.
     */
   public function autoSearch(Request $request)
{
    $query = $request->get('query');
    $cities = $request->get('cities'); // ✅ Array of selected cities

    $results = Property::with(['images' => function ($q) {
            $q->where('is_thumbnail', 1); // ✅ Load only thumbnail image
        }])
        ->when($query, function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%");
        })
        ->when($cities, function ($q) use ($cities) {
            $q->whereIn('city', $cities); // ✅ Filter by selected cities
        })
        ->limit(10)
        ->get();

    return response()->json($results);
}

}
