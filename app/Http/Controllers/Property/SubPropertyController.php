<?php

namespace App\Http\Controllers\Property;

use App\Models\SubProperty;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\property\SubPropertyRequest;

class SubPropertyController extends Controller
{
    public function store(SubPropertyRequest $request, $propertyId)
    {
        // Find the property by ID
        $property = Property::findOrFail($propertyId);


        // Create the sub-property with the relationship
        $subProperty = $property->subProperties()->create($request->validated());

        return response()->json([
            'message' => 'Sub-property created successfully!',
            'subProperty' => $subProperty,
        ], 201);
    }
}
