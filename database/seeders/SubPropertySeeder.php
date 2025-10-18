<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\SubProperty;
use Illuminate\Support\Facades\Log;

class SubPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();

        // Check if properties exist
        if ($properties->isEmpty()) {
            Log::warning('No properties found. SubPropertySeeder cannot create records without existing properties.');
            return; // Exit early to avoid errors
        }

        foreach ($properties as $property) {
            SubProperty::create([
                'title' => 'Sub-' . $property->title, // Prefix "Sub-" to the parent property title
                'bedrooms' => max(1, $property->bedrooms - 1), // Reduce bedrooms, ensure at least 1
                'bathrooms' => max(1, $property->bathrooms - 1), // Reduce bathrooms, ensure at least 1
                'garages' => $property->garages, // Same as parent property
                'garage_size' => $property->garages_size, // Map to 'garage_size' (singular) from 'garages_size'
                'area_size' => $property->area_size * 0.8, // Reduce area size by 20% for example
                'size_prefix' => $property->size_prefix, // Same as parent property
                'price' => $property->price * 0.8, // Reduce price by 20% for example
                'price_label' => $property->price_prefix ,
                'property_id' => $property->id, // Foreign key to link to parent Property
            ]);
        }

    }
}
