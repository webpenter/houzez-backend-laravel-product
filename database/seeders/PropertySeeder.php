<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 properties (you had 10,000 before — change if you need)
        Property::factory(10)
            ->create()
            ->each(function ($property) {

                // Generate full URL using asset() (uses APP_URL from .env)
                $fullUrl = asset('property_images/68d5091b049d1_placeholder.jpg');

                // Attach 3 images per property
                $property->images()->createMany([
                    ['image_path' => $fullUrl, 'is_thumbnail' => true],
                    ['image_path' => $fullUrl, 'is_thumbnail' => false],
                    ['image_path' => $fullUrl, 'is_thumbnail' => false],
                ]);
            });
    }
}
