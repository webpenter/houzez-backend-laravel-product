<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\PropertyImage;

interface PropertyImageRepositoryInterface
{
    /**
     * ## Handles the creation or update of property images.
     *
     * @param Request $request
     * @param int $propertyId
     * @return array
     */
    public function createOrUpdateImages(Request $request, $propertyId): array;

    /**
     * ## Get Images by Property ID
     *
     * Retrieves all images associated with a property.
     *
     * @param int $propertyId The ID of the property.
     * @return Collection Collection of PropertyImage instances.
     */
    public function getImagesByPropertyId(int $propertyId): Collection;

    /**
     * ## Update Thumbnail
     *
     * Sets a specific image as the thumbnail for a property.
     *
     * @param int $propertyId The ID of the property.
     * @param int $imageId The ID of the image to be set as the thumbnail.
     * @return bool True if successful, false otherwise.
     */
    public function updateThumbnail(int $propertyId, int $imageId): bool;

    /**
     * ## Delete Image
     *
     * Deletes an image from the property and updates the thumbnail if necessary.
     *
     * @param int $propertyId The ID of the property.
     * @param int $imageId The ID of the image to be deleted.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteImage(int $propertyId, int $imageId): bool;
}
