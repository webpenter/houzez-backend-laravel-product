<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Store a new property.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package' => 'required|string',
            'price' => 'required|numeric',
            'time_period' => 'required|string',
            'number_of_listings' => 'required|integer',
            'featured_listings' => 'required|integer',
            'number_of_images' => 'required|integer',
        ]);

        $property = Property::createProperty($validated);

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully!',
            'data' => $property,
        ], 201);
    }

    /**
     * Update a property.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'package' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'time_period' => 'sometimes|string',
            'number_of_listings' => 'sometimes|integer',
            'featured_listings' => 'sometimes|integer',
            'number_of_images' => 'sometimes|integer',
        ]);

        $property->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully!',
            'data' => $property,
        ]);
    }

    /**
     * Delete a property.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully!',
        ]);
    }

    /**
     * Get all properties for the authenticated user.
     */
    public function index()
    {
        $properties = Auth::user()->properties;

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }
}
