<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the 4 demo images
        $images = [
            'https://demo01.houzez.co/wp-content/uploads/2016/03/035.jpg',
            'https://demo01.houzez.co/wp-content/uploads/2016/03/036.jpg',
            'https://demo01.houzez.co/wp-content/uploads/2016/03/040.jpg',
            'https://demo01.houzez.co/wp-content/uploads/2016/03/045.jpg',
            'https://demo01.houzez.co/wp-content/uploads/2016/02/038.jpg',
            'https://demo01.houzez.co/wp-content/uploads/2016/03/008.jpg',
        ];

        // Fetch all properties
        $properties = Property::all();

        foreach ($properties as $property) {
            // Remove old images first to avoid duplicates when reseeding
            $property->images()->delete();

            foreach ($images as $index => $image) {
                PropertyImage::create([
                    'property_id'  => $property->id,
                    'image_path'   => $image,
                    'is_thumbnail' => $index === 0, // First image is thumbnail
                ]);
            }
        }
    }
}
