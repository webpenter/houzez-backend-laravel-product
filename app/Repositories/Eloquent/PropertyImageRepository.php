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
     * ## Handles the creation or update of property images.
     *
     * @param Request $request
     * @param int $propertyId
     * @return array
     */
    public function createOrUpdateImages(Request $request, $propertyId): array
    {
        $images = $request->file('images');

        $existingImages = PropertyImage::where('property_id', $propertyId)->count();

        if ($existingImages >= 6) {
            return [
                'status' => 422,
                'response' => ['message' => 'This property already has 6 images, no more can be uploaded.']
            ];
        }

        $remainingSlots = 6 - $existingImages;

        if (count($images) > $remainingSlots) {
            return [
                'status' => 400,
                'response' => ['message' => "You can upload only $remainingSlots more images."]
            ];
        }

        $imagePaths = [];
        foreach ($images as $image) {
            $destinationPath = public_path('property_images');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);

            $fullPath = url('property_images/' . $filename);

            $imageRecord = PropertyImage::create([
                'property_id' => $propertyId,
                'image_path' => $fullPath,
                'is_thumbnail' => false,
            ]);

            $imagePaths[] = $imageRecord;
        }

        if ($existingImages == 0) {
            $imagePaths[0]->update(['is_thumbnail' => true]);
        } else {
            $thumbnailImage = PropertyImage::where('property_id', $propertyId)
                ->where('is_thumbnail', true)
                ->first();

            if (!$thumbnailImage) {
                $imagePaths[0]->update(['is_thumbnail' => true]);
            }
        }

        return [
            'status' => 200,
            'response' => [
                'message' => 'Images uploaded successfully',
                'images' => $imagePaths,
            ]
        ];
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
