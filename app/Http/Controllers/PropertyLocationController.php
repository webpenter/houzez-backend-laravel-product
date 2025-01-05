<?php

namespace App\Http\Controllers;

use App\Models\PropertyLocation;
use Illuminate\Http\Request;

class PropertyLocationController extends Controller
{
    // Get all locations
    public function index()
    {
        return response()->json(PropertyLocation::all());
    }

    // Create a new location
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'county_state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'map_street_view' => 'nullable|string',
        ]);

        $location = PropertyLocation::create($validated);

        return response()->json([
            'message' => 'Property location created successfully.',
            'data' => $location,
        ], 201);
    }

    // Show a specific location
    public function show($id)
    {
        $location = PropertyLocation::findOrFail($id);

        return response()->json($location);
    }

    // Update a location
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'address' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:100',
            'county_state' => 'sometimes|string|max:100',
            'city' => 'sometimes|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'map_street_view' => 'nullable|string',
        ]);

        $location = PropertyLocation::findOrFail($id);
        $location->update($validated);

        return response()->json([
            'message' => 'Property location updated successfully.',
            'data' => $location,
        ]);
    }

    // Delete a location
    public function destroy($id)
    {
        $location = PropertyLocation::findOrFail($id);
        $location->delete();

        return response()->json([
            'message' => 'Property location deleted successfully.',
        ]);
    }
}
