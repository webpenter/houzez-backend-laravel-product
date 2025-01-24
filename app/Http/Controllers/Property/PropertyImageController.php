<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Http\Requests\Property\PropertyImageRequest; // Import the custom request
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    public function store(PropertyImageRequest $request, $propertyId)
    {
        
        $property = Property::findOrFail($propertyId);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the image to the public folder 'property-images' and get the path
            $imagePath = $image->move(public_path('property-images'), $imageName);

            // Create the PropertyImage record in the database
            $propertyImage = PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => 'property-images/' . $imageName, // Store relative path
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'image' => $propertyImage
            ], 200);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
}