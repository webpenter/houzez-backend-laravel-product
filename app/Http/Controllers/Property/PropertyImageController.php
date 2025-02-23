<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyImageRequest;
use App\Models\PropertyImage;
use App\Repositories\PropertyImageRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyImageController extends Controller
{
    protected $propertyImageRepository;

    /**
     * Inject the PropertyImageRepository into the controller.
     *
     * @param PropertyImageRepositoryInterface $propertyImageRepository
     */
    public function __construct(PropertyImageRepositoryInterface $propertyImageRepository)
    {
        $this->propertyImageRepository = $propertyImageRepository;
    }

    /**
     * ## Handles the creation or update of property images.
     *
     * @param PropertyImageRequest $request
     * @param int $propertyId
     * @return JsonResponse
     */
    public function imagesCreateOrUpdate(PropertyImageRequest $request, $propertyId): JsonResponse
    {
        $result = $this->propertyImageRepository->createOrUpdateImages($request, $propertyId);
        return new JsonResponse($result['response'], $result['status']);
    }

    /**
     * ## Retrieve Property Images
     *
     * Fetches all images for a given property.
     *
     * @param int $propertyId
     * @return JsonResponse
     */
    public function getImages($propertyId): JsonResponse
    {
        $images = $this->propertyImageRepository->getImagesByPropertyId($propertyId);

        if ($images->isEmpty()) {
            return new JsonResponse([
                'message' => 'No images found.'
            ], 404);
        }

        return new JsonResponse([
            'images' => $images
        ], 200);
    }

    /**
     * ## Update Thumbnail
     *
     * Sets a new thumbnail image for a property.
     *
     * @param int $propertyId
     * @param int $imageId
     * @return JsonResponse
     */
    public function updateThumbnail($propertyId, $imageId): JsonResponse
    {
        return new JsonResponse([
            'success' => $this->propertyImageRepository->updateThumbnail($propertyId, $imageId)
        ], 200);
    }

    /**
     * ## Delete Image
     *
     * Removes an image and updates the thumbnail if needed.
     *
     * @param int $propertyId
     * @param int $imageId
     * @return JsonResponse
     */
    public function deleteImage($propertyId, $imageId): JsonResponse
    {
        return new JsonResponse([
            'success' => $this->propertyImageRepository->deleteImage($propertyId, $imageId)
        ], 200);
    }
}
