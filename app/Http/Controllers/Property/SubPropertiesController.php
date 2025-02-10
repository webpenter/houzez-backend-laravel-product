<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\SubPropertiesRequest;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class SubPropertiesController extends Controller
{
    public function createOrUpdate(SubPropertiesRequest $request, $propertyId, $subPropertyId = null): JsonResponse
    {
        try {
            $property = Property::findOrFail($propertyId);

            $data = $request->validated();

            $subPropertiesData = $data['subProperties'];
            $storedSubProperties = [];

            foreach ($subPropertiesData as $subProperty) {
                if ($subPropertyId) {
                    $existingSubProperty = $property->subProperties()->find($subPropertyId);

                    if ($existingSubProperty) {
                        $existingSubProperty->update($subProperty);
                        $storedSubProperties[] = $existingSubProperty;
                    } else {
                        return response()->json([
                            'message' => 'Sub-property not found.',
                        ], 404);
                    }
                } else {
                    $subProperty['property_id'] = $propertyId;
                    $storedSubProperties[] = $property->subProperties()->create($subProperty);
                }
            }

            return response()->json([
                'message' => $subPropertyId ? 'Sub-property updated successfully!' : 'Sub-property(s) created successfully!',
                'subProperties' => $storedSubProperties,
            ], $subPropertyId ? 200 : 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
