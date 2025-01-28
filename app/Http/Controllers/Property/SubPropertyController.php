<?php

namespace App\Http\Controllers\Property;

use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\property\SubPropertyRequest;
use Exception;
use Illuminate\Validation\ValidationException;

class SubPropertyController extends Controller
{
    public function storeOrUpdate(SubPropertyRequest $request, $propertyId, $subPropertyId = null)
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
