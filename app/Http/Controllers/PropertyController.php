<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\AddPropertyRequestStep1;
use App\Http\Requests\Property\AddPropertyRequestStep10;
use App\Http\Requests\Property\AddPropertyRequestStep12;
use App\Http\Requests\Property\AddPropertyRequestStep2;
use App\Http\Requests\Property\AddPropertyRequestStep3;
use App\Http\Requests\Property\AddPropertyRequestStep4;
use App\Http\Requests\Property\AddPropertyRequestStep5;
use App\Http\Requests\Property\AddPropertyRequestStep6;
use App\Http\Requests\Property\AddPropertyRequestStep7;
use App\Models\Property;

class PropertyController extends Controller
{
    //update
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
     * Store a new property.
     */
    public function storestep1(AddPropertyRequestStep1 $request)
    {
        // Validation is automatically applied
        $validated = $request->validated(); 
        // Save the property record
        $property = Property::create($validated);
 
        // Return the newly created property with the success message
        return response()->json([
            'message' => 'Property step 1 saved successfully!',
            'property' => $property
        ], 201); // Use 201 status code for created resources
    }

    public function storestep2(AddPropertyRequestStep2 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep3(AddPropertyRequestStep3 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep4(AddPropertyRequestStep4 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep5(AddPropertyRequestStep5 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }
     
    public function storestep6(AddPropertyRequestStep6 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep7(AddPropertyRequestStep7 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep10(AddPropertyRequestStep10 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    public function storestep12(AddPropertyRequestStep12 $request, Property $property)
    {
        // Validation is automatically applied
        $validated = $request->validated();

        // You don't need to find the property since it's already passed via route model binding.
        // You can update the property with validated data
        $property->update($validated);

        // Return the updated property with a success message
        return response()->json([
            'message' => 'Property updated successfully!',
            'property' => $property
        ], 200); // Use 200 status code for successful updates
    }

    /**
     * Update a property.
     */
    // public function update(Request $request, Property $property)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'package' => 'nullable|string',
    //         'title' => 'sometimes|string|max:255',
    //         'country' => 'required|string|max:100',
    //         'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Limit file types and size
    //         'county_state' => 'required|string|max:100',
    //         'city' => 'required|string|max:100',
    //         'neighborhood' => 'nullable|string|max:100',
    //         'postal_code' => 'required|string|max:20',
    //         'latitude' => 'required|numeric',
    //         'longitude' => 'required|numeric',
    //         'map_street_view' => 'nullable|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'video_url' => 'nullable|url',
    //         'description' => 'nullable|string',
    //         'type' => 'nullable|string',
    //         'energy_class' => 'required|string|max:50',
    //         'global_energy_performance_index' => 'required|numeric',
    //         'renewable_energy_performance_index' => 'required|numeric',
    //         'status' => 'nullable|in:draft,published,pending,expired,hold,disapproved',
    //         'labels' => 'nullable|string',
    //         'price' => 'sometimes|numeric',
    //         'second_price' => 'nullable|numeric',
    //         'after_price_label' => 'nullable|string',
    //         'price_label' => 'nullable|string|max:255',
    //         'price_prefix' => 'nullable|string',
    //         'virtual_tour' => 'required|string',
    //         'private_note' => 'nullable|string', // Private note validation
    //         'custom_fields' => 'nullable|string',
    //         'bedrooms' => 'sometimes|integer|min:0',
    //         'bathrooms' => 'sometimes|integer|min:0',
    //         'garages' => 'nullable|integer|min:0',
    //         'garages_size' => 'nullable|string|max:255',
    //         'area_size' => 'sometimes|integer|min:0',
    //         'size_prefix' => 'nullable|string|max:50',
    //         'land_area' => 'nullable|integer|min:0',
    //         'land_area_size_postfix' => 'nullable|string|max:50',
    //         'user_id' => 'sometimes|string|max:50',
    //         'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
    //         'additional_details' => 'required|string',
    //         'additional_details.*.title' => 'required_with:additional_details|string|max:255',
    //         'additional_details.*.value' => 'required_with:additional_details|string|max:255',
    //     ]);

    //     $property->update($validated);
    //     if ($request->hasFile('image')) {
    //         $property->image = $request->file('image')->store('images', 'public');
    //     }

    //     $property->video_url = $request->video_url ?? $property->video_url;
    //     $property->save();
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Property updated successfully!',
    //         'data' => $property,
    //     ]);
    // }

    /**
     * Delete a property.
     */
    public function destroy(Property $property)
    {
        // Delete the property
        $property->delete();

        // Return a success message
        return response()->json([
            'message' => 'Property deleted successfully!'
        ], 200); // Use 200 status code for successful deletion
    }

}
