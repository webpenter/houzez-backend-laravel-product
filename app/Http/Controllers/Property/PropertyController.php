<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\property\FloorPlanRequest;
use App\Http\Requests\Property\PropertyRequest;
use App\Http\Requests\property\SubPropertyRequest;
use App\Http\Resources\Property\EditPropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\PropertyImage;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

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

    public function planStoreOrUpdate(FloorPlanRequest $request, $propertyId, $floorPlanId = null)
    {
        try {
            // Step 1: Check if the property exists
            $property = Property::findOrFail($propertyId);

            // Step 2: Initialize the validated data from the request
            $data = $request->validated();

            // Step 3: Extract the floor plans from the validated data
            $floorPlansData = $data['floorPlans'];
            $storedFloorPlans = [];

            // Step 4: Loop through the floor plans data
            foreach ($floorPlansData as $floorPlan) {
                // Step 5: Check if an image is present and handle the image upload
                if (isset($floorPlan['plan_image']) && $floorPlan['plan_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $image = $floorPlan['plan_image'];

                    // Generate a unique name for the image file
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    // Define the path to store the image
                    $destinationPath = public_path('floorplans');

                    // Ensure the directory exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    // Move the uploaded file to the destination
                    $image->move($destinationPath, $imageName);

                    // Set the full URL for the stored image
                    $floorPlan['plan_image'] = url('floorplans/' . $imageName);
                }

                // Step 6: Check if floorPlanId is passed in the URL
                if ($floorPlanId) {
                    // Try to find the existing floor plan for the given property
                    $existingFloorPlan = $property->floorPlans()->find($floorPlanId);

                    if ($existingFloorPlan) {
                        // If the floor plan exists, update it
                        $existingFloorPlan->update($floorPlan);
                        $storedFloorPlans[] = $existingFloorPlan;
                    } else {
                        // If the floor plan doesn't exist, return a 404 response
                        return response()->json([
                            'message' => 'Floor plan not found.',
                        ], 404);
                    }
                } else {
                    // If no floor plan ID is passed, create a new floor plan
                    $floorPlan['property_id'] = $propertyId; // Associate the floor plan with the property
                    $storedFloorPlans[] = $property->floorPlans()->create($floorPlan);
                }
            }

            // Step 7: Return success response with the appropriate message
            return response()->json([
                'message' => $floorPlanId ? 'Floor plan updated successfully!' : 'Floor plan(s) created successfully!',
                'floorPlans' => $storedFloorPlans,
            ], $floorPlanId ? 200 : 201);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function subPropertyStoreOrUpdate(SubPropertyRequest $request, $propertyId, $subPropertyId = null)
    {
        try {
            // Step 1: Find the property by ID
            $property = Property::findOrFail($propertyId);

            // Step 2: Initialize the validated data from the request
            $data = $request->validated();

            // Step 3: Extract the sub-properties data from the validated data
            $subPropertiesData = $data['subProperties'];
            $storedSubProperties = [];

            // Step 4: Loop through the sub-properties data
            foreach ($subPropertiesData as $subProperty) {
                // Step 5: Check if subPropertyId is passed in the URL
                if ($subPropertyId) {
                    // Try to find the existing sub-property for the given property
                    $existingSubProperty = $property->subProperties()->find($subPropertyId);

                    if ($existingSubProperty) {
                        // If the sub-property exists, update it
                        $existingSubProperty->update($subProperty);
                        $storedSubProperties[] = $existingSubProperty;
                    } else {
                        // If the sub-property doesn't exist, return a 404 response
                        return response()->json([
                            'message' => 'Sub-property not found.',
                        ], 404);
                    }
                } else {
                    // If no sub-property ID is passed, create a new sub-property
                    $subProperty['property_id'] = $propertyId; // Associate the sub-property with the property
                    $storedSubProperties[] = $property->subProperties()->create($subProperty);
                }
            }

            // Step 6: Return success response with the appropriate message
            return response()->json([
                'message' => $subPropertyId ? 'Sub-property updated successfully!' : 'Sub-property(s) created successfully!',
                'subProperties' => $storedSubProperties,
            ], $subPropertyId ? 200 : 201);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
