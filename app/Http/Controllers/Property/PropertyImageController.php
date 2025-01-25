<?php

namespace App\Http\Controllers\Property; 

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Http\Requests\Property\PropertyImageRequest;


class PropertyImageController extends Controller
{
    public function store(PropertyImageRequest $request, $propertyId)
    {
        // Fetch the property
        $property = Property::findOrFail($propertyId);

        // Initialize an array to store image paths
        $storedImages = [];

        // Process each image
        foreach ($request->file('images') as $image) {
            // Generate a unique name for the image
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Use the move method to store the image in the 'property-images' folder
            $image->move(public_path('property-images'), $imageName);

            // Save the image to the database
            $propertyImage = PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => 'property-images/' . $imageName, // Store the relative path
            ]);

            // Add the saved image to the response array
            $storedImages[] = $propertyImage;
        }

        // Return a success response
        return response()->json([
            'message' => 'Images uploaded successfully!',
            'images' => $storedImages,
        ], 200);
    }
}