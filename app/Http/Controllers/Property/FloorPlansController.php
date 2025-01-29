<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\FloorPlansRequest;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class FloorPlansController extends Controller
{
    public function createOrUpdate(FloorPlansRequest $request, $propertyId, $floorPlanId = null): JsonResponse
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
}
