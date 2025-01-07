<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Store a new property.
     */
    
    public function store(Request $request)
    {
    
        $validated = $request->validate([
            'name' => 'required|string',
            'package' => 'nullable|string',
            'property_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Limit file types and size
            'county_state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'virtual_tour' => 'nullable|string',
            'private_note' => 'nullable|string', // Private note validation
            'neighborhood' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'map_street_view' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
            'address' => 'required|string',
            'features' => 'required|string', // Handle array of features
            'features.*' => 'string', // Each feature is a string
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'status' => 'nullable|in:draft,published,pending,expired,hold,disapproved',
            'labels' => 'nullable|string',
            'price' => 'required|numeric',
            'second_price' => 'nullable|numeric',
            'after_price_label' => 'nullable|string',
            'price_label' => 'nullable|string|max:255',
            'price_prefix' => 'nullable|string',
            'custom_fields' => 'nullable|string',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'garages_size' => 'nullable|string|max:255',
            'area_size' => 'required|integer|min:0',
            'size_prefix' => 'nullable|string|max:50',
            'land_area' => 'nullable|integer|min:0',
            'land_area_size_postfix' => 'nullable|string|max:50',
            'user_id' => 'required|string|max:50',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'additional_details' => 'nullable|array',
                'additional_details.*.title' => 'required_with:additional_details|string|max:255',
                'additional_details.*.value' => 'required_with:additional_details|string|max:255',

        ]);

        $property = Property::create($validated);
        if ($request->hasFile('image')) {
            $property->image = $request->file('image')->store('images', 'public');
        }

        $property->video_url = $request->video_url;
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
            'name' => 'required|string',
            'package' => 'nullable|string',
            'title' => 'sometimes|string|max:255',
            'country' => 'required|string|max:100',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Limit file types and size
            'county_state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'map_street_view' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'energy_class' => 'required|string|max:50',
            'global_energy_performance_index' => 'required|numeric',
            'renewable_energy_performance_index' => 'required|numeric',
            'status' => 'nullable|in:draft,published,pending,expired,hold,disapproved',
            'labels' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'second_price' => 'nullable|numeric',
            'after_price_label' => 'nullable|string',
            'price_label' => 'nullable|string|max:255',
            'price_prefix' => 'nullable|string',
            'virtual_tour' => 'required|string',
            'private_note' => 'nullable|string', // Private note validation
            'custom_fields' => 'nullable|string',
            'bedrooms' => 'sometimes|integer|min:0',
            'bathrooms' => 'sometimes|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'garages_size' => 'nullable|string|max:255',
            'area_size' => 'sometimes|integer|min:0',
            'size_prefix' => 'nullable|string|max:50',
            'land_area' => 'nullable|integer|min:0',
            'land_area_size_postfix' => 'nullable|string|max:50',
            'user_id' => 'sometimes|string|max:50',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'additional_details' => 'required|string',
            'additional_details.*.title' => 'required_with:additional_details|string|max:255',
            'additional_details.*.value' => 'required_with:additional_details|string|max:255',
        ]);

        $property->update($validated);
        if ($request->hasFile('image')) {
            $property->image = $request->file('image')->store('images', 'public');
        }

        $property->video_url = $request->video_url ?? $property->video_url;
        $property->save();
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
        $properties = Auth::user()->properties; // Ensure the 'properties' relationship exists in the User model.

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }

    /**
     * Get a single property by ID.
     */
    public function show($id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json($property, 200);
    }
}
