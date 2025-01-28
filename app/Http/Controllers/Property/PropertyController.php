<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyRequest;
use App\Http\Resources\Property\EditPropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\PropertyImage;

class PropertyController extends Controller
{
    /**
     * Store or update a property.
     *
     * This method handles both the creation of a new property and the updating of an existing property.
     *
     * - If an ID is provided, it will attempt to find the property and update it.
     * - If no ID is provided, a new property will be created.
     *
     * The request is automatically validated using the PropertyRequest class. If validation fails,
     * a 422 Unprocessable Entity response with validation errors will be returned.
     *
     * Any other exceptions (e.g., database errors) are caught and a 500 Internal Server Error response
     * with a generic error message will be returned.
     *
     * @param PropertyRequest $request The validated request containing property data.
     * @param int|null $id The ID of the property to update, or null to create a new property.
     *
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function storeOrUpdate(PropertyRequest $request, $id = null): JsonResponse
    {
        try {
            $data = $request->validated();

            $data['user_id'] = Auth::id();
            $data['property_feature'] = $request->input('property_feature', []);


            if ($id) {
                $property = Property::find($id);

                if (!$property) {
                    return response()->json(['message' => 'Property not found.'], 404);
                }

                if ($property->user_id !== Auth::id()) {
                    return response()->json([
                        'message' => 'You are not authorized to update this property.',
                    ], 403);
                }

                $property->update($data);

                return response()->json([
                    'message' => 'Property updated successfully.',
                    'property' => $property,
                ], 200);
            } else {
                $property = Property::create($data);

                return response()->json([
                    'message' => 'Property created successfully.',
                    'property' => $property,
                ], 201);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Edit a property by the authenticated user.
     *
     * This method handles the request to edit a property. It first checks if the property exists,
     * then verifies if the current authenticated user is the owner of the property.
     * If either check fails, an appropriate error response is returned. If both checks pass,
     * a success response with the property's details is returned.
     *
     * @param  Property  $property  The property to be edited.
     * @return JsonResponse  The response containing the result of the edit operation.
     */
    public function edit(Property $property): JsonResponse
    {
        if (!$property) {
            return response()->json([
                'status' => 'error',
                'message' => 'Property not found or ID does not match.',
            ], 404);
        }

        if ($property->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to edit this property.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'property' => new EditPropertyResource($property),
        ], 200);
    }

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

}
