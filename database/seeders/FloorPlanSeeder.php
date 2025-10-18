<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\FloorPlan;
use Illuminate\Support\Facades\Log;

class FloorPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();

        // Check if properties exist
        if ($properties->isEmpty()) {
            Log::warning('No properties found. FloorPlanSeeder cannot create records without existing properties.');
            return; // Exit early to avoid errors
        }

        foreach ($properties as $property) {
            FloorPlan::create([
                'plan_title' => 'Floor Plan for ' . $property->title,
                'plan_bedrooms' => max(1, $property->bedrooms), // Use same bedrooms as property, ensure at least 1
                'plan_bathrooms' => max(1, $property->bathrooms), // Use same bathrooms as property, ensure at least 1
                'plan_price' => $property->price * 0.9, // Slightly reduced price for example (e.g., 90% of property price)
                'price_postfix' => $property->after_price, // Map to 'after_price' from Property (e.g., "month")
                'plan_image' => 'https://demo01.houzez.co/wp-content/uploads/2016/03/045.jpg', // Placeholder image URL
                'plan_description' => 'Floor plan for ' . $property->title . '. ' . substr($property->description, 0, 200) . '...', // Shortened description
                'property_id' => $property->id, // Foreign key to link to parent Property
            ]);
        }

    }
}
