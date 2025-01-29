<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Models\PropertyImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyImageController extends Controller
{
    /**
     * Handles the creation or update of property images.
     *
     * Validates the uploaded images, ensures the property does not exceed 6 images,
     * stores the images in the public directory, and updates the database.
     *
     * @param Request $request The HTTP request containing image files.
     * @param int $propertyId The ID of the property.
     * @return JsonResponse JSON response with success or error messages.
     */
    public function imagesCreateOrUpdate(Request $request, $propertyId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'required|array|min:1|max:6', // Limit the number of images to 6
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $images = $request->file('images');

        $existingImages = PropertyImage::where('property_id', $propertyId)->count();

        if ($existingImages >= 6) {
            return response()->json(['message' => 'This property already has 6 images, no more can be uploaded.'], 422);
        }

        $remainingSlots = 6 - $existingImages;

        if (count($images) > $remainingSlots) {
            return response()->json(['message' => "You can upload only $remainingSlots more images."], 400);
        }

        $imagePaths = [];
        foreach ($images as $key => $image) {
            $destinationPath = public_path('property_images');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
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

        return response()->json([
            'message' => 'Images uploaded successfully',
            'images' => $imagePaths,
        ]);
    }

    /**
     * Retrieves all images for a given property.
     *
     * Fetches images from the database based on the property ID.
     * Returns a JSON response with the images or an error message if no images are found.
     *
     * @param int $propertyId The ID of the property.
     * @return JsonResponse JSON response containing the images or an error message.
     */
    public function egitImages($propertyId): JsonResponse
    {
        $images = PropertyImage::where('property_id', $propertyId)->get();

        if ($images->isEmpty()) {
            return response()->json([
                'message' => 'No images found for this property.',
                'images' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Images retrieved successfully.',
            'images' => $images,
        ],200);
    }

    /**
     * API to update the thumbnail for a given property_id and image_id.
     *
     * This function performs the following:
     * 1. Resets the 'is_thumbnail' value to 0 for all images with the same property_id.
     * 2. Sets 'is_thumbnail' to 1 for the image with the given image_id and property_id.
     *
     * Example usage:
     * PUT /api/update-thumbnail/{property_id}/{image_id}
     *
     * @param int $property_id The ID of the property.
     * @param int $image_id The ID of the image to set as the thumbnail.
     *
     * @return \Illuminate\Http\JsonResponse Response indicating success or failure.
     */
    public function updateThumbnail($property_id, $image_id): JsonResponse
    {
        PropertyImage::where('property_id', $property_id)->update(['is_thumbnail' => 0]);

        $image = PropertyImage::where('id', $image_id)
            ->where('property_id', $property_id)
            ->first();

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $image->is_thumbnail = 1;
        $image->save();

        return response()->json(['success' => 'Thumbnail updated successfully'],200);
    }

    /**
     * Delete an image from a property.
     *
     * This method deletes an image by its ID for a given property. If the image being deleted
     * is marked as the thumbnail, the next available image will be assigned as the new thumbnail.
     * It also removes the image file from the server and deletes the image record from the database.
     *
     * @param  int  $propertyId  The ID of the property the image belongs to.
     * @param  int  $imageId     The ID of the image to be deleted.
     * @return JsonResponse      A JSON response indicating the result of the operation.
     */
    public function deleteImage($propertyId, $imageId): JsonResponse
    {
        $image = PropertyImage::where('id', $imageId)->where('property_id', $propertyId)->first();

        if (!$image) {
            return response()->json(['message' => 'Image not found or does not belong to the given property.'], 404);
        }

        if ($image->is_thumbnail) {
            $nextThumbnail = PropertyImage::where('property_id', $propertyId)
                ->where('is_thumbnail', false)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($nextThumbnail) {
                $nextThumbnail->update(['is_thumbnail' => true]);
            }
        }

        $imagePath = public_path('property_images') . '/' . basename(parse_url($image->image_path, PHP_URL_PATH));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
