<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyRequest;
use App\Http\Resources\Property\EditPropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Get all properties for the authenticated user.
     */
    public function index()
    {
        // Retrieve all properties, you can paginate if needed
        $properties = Property::all();

        return response()->json([
            'message' => 'Successfully fetch all properties!',
            'properties' => $properties,
        ]);
    }

    /**
     * Get a single property by ID.
     */
    public function show(Property $property)
    {
        // Return the property as a JSON response
        return response()->json([
            'message' => 'Property retrieved successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful retrieval
    }

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

            if ($id) {
                // Update the existing property if the ID is provided
                $property = Property::find($id);

                if (!$property) {
                    return response()->json(['message' => 'Property not found.'], 404);
                }

                $property->update($data);

                return response()->json([
                    'message' => 'Property updated successfully.',
                    'property' => $property,
                ], 200);
            } else {
                // Create a new property if no ID is provided
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

}
