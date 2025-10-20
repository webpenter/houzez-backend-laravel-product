<?php

namespace App\Repositories\Eloquent;

use App\Models\PropertyImage;
use App\Repositories\PropertyImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyImageRepository implements PropertyImageRepositoryInterface
{
/**
     * ✅ Handles uploading and saving property images securely.
     * - Limits max images to 6 per property.
     * - Saves images using Laravel Storage (better for production & CDN).
     * - Generates full URL with domain.
     * - Automatically marks the first image as thumbnail if none exists.
     *
     * @param Request $request
     * @param int $propertyId
     * @return array
     */
    public function createOrUpdateImages(Request $request, $propertyId): array
    {
        $images = $request->file('images');

        // ✅ Count existing images for this property
        $existingImages = PropertyImage::where('property_id', $propertyId)->count();

        // ✅ Validate image limit (max 6)
        if ($existingImages >= 6) {
            return [
                'status' => 422,
                'response' => ['message' => 'Maximum of 6 images allowed for this property.']
            ];
        }

        // ✅ Calculate remaining slots
        $remainingSlots = 6 - $existingImages;

        if (count($images) > $remainingSlots) {
            return [
                'status' => 400,
                'response' => ['message' => "You can upload only $remainingSlots more images."]
            ];
        }

        $imageRecords = [];

        foreach ($images as $image) {
            // ✅ Generate secure and unique file name
            $filename = uniqid('property_') . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

            // ✅ Store image using Laravel storage
            $path = $image->storeAs('property_images', $filename, 'public');

            // ✅ Generate full domain-based URL
            $fullUrl = url('storage/' . $path);

            // ✅ Save image record in DB
            $imageRecord = PropertyImage::create([
                'property_id' => $propertyId,
                'image_path'  => $fullUrl,
                'is_thumbnail'=> false,
            ]);

            $imageRecords[] = $imageRecord;
        }

        // ✅ If no previous images, set first image as thumbnail
        $this->setThumbnailIfNotExists($propertyId, $imageRecords[0] ?? null);

        return [
            'status' => 200,
            'response' => [
                'message' => 'Images uploaded successfully!',
                'images'  => $imageRecords,
            ]
        ];
    }

    /**
     * ✅ Sets the first image as thumbnail if none is set already.
     */
    private function setThumbnailIfNotExists(int $propertyId, $newImage = null): void
    {
        $existingThumbnail = PropertyImage::where('property_id', $propertyId)
            ->where('is_thumbnail', true)
            ->first();

        if (!$existingThumbnail && $newImage) {
            $newImage->update(['is_thumbnail' => true]);
        }
    }


    /**
     * ## Get Images by Property ID
     *
     * Fetches all images for a property.
     *
     * @param int $propertyId The ID of the property.
     * @return Collection Collection of PropertyImage instances.
     */
    public function getImagesByPropertyId(int $propertyId): Collection
    {
        return PropertyImage::where('property_id', $propertyId)->get();
    }

    /**
     * ## Update Thumbnail
     *
     * Marks a specific image as the thumbnail for a property.
     *
     * @param int $propertyId The ID of the property.
     * @param int $imageId The ID of the image.
     * @return bool True if successful, false otherwise.
     */
    public function updateThumbnail(int $propertyId, int $imageId): bool
    {
        PropertyImage::where('property_id', $propertyId)->update(['is_thumbnail' => 0]);

        $image = PropertyImage::where('id', $imageId)
            ->where('property_id', $propertyId)
            ->first();

        if (!$image) {
            return false;
        }

        $image->update(['is_thumbnail' => true]);

        return true;
    }

    /**
     * ## Delete Image
     *
     * Deletes an image and assigns a new thumbnail if needed.
     *
     * @param int $propertyId The ID of the property.
     * @param int $imageId The ID of the image.
     * @return bool True if successful, false otherwise.
     */
    public function deleteImage(int $propertyId, int $imageId): bool
    {
        $image = PropertyImage::where('id', $imageId)
            ->where('property_id', $propertyId)
            ->first();

        if (!$image) {
            return false;
        }

        if ($image->is_thumbnail) {
            $nextThumbnail = PropertyImage::where('property_id', $propertyId)
                ->where('id', '!=', $imageId)
                ->first();

            if ($nextThumbnail) {
                $nextThumbnail->update(['is_thumbnail' => true]);
            }
        }

        $imagePath = public_path('property_images') . '/' . basename(parse_url($image->image_path, PHP_URL_PATH));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $image->delete();
    }
}
