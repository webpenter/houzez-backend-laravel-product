<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Store a new listing.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'labels' => 'nullable|string',
            'price' => 'required|numeric',
            'second_price' => 'nullable|numeric',
            'after_price_label' => 'nullable|string',
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
            'user_id' => 'required|string|max:50|unique:listings',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'additional_details' => 'nullable|array',
            'additional_details.*.title' => 'required_with:additional_details|string|max:255',
            'additional_details.*.value' => 'required_with:additional_details|string|max:255',
        ]);

        $listing = Listing::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Listing created successfully!',
            'data' => $listing,
        ], 201);
    }

    /**
     * Update a listing.
     */
    public function update(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'labels' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'second_price' => 'nullable|numeric',
            'after_price_label' => 'nullable|string',
            'price_prefix' => 'nullable|string',
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
            'additional_details' => 'nullable|array',
            'additional_details.*.title' => 'required_with:additional_details|string|max:255',
            'additional_details.*.value' => 'required_with:additional_details|string|max:255',
        ]);

        $listing->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Listing updated successfully!',
            'data' => $listing,
        ]);
    }

    /**
     * Delete a listing.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Listing deleted successfully!',
        ]);
    }

    /**
     * Get all listings for the authenticated user.
     */
    public function index()
    {
        $listings = Auth::user()->listings; // Ensure the 'listings' relationship exists in the User model.

        return response()->json([
            'success' => true,
            'data' => $listings,
        ]);
    }

    /**
     * Get a single listing by ID.
     */
    public function show($id)
    {
        $listing = Listing::find($id);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }

        return response()->json($listing, 200);
    }
}
