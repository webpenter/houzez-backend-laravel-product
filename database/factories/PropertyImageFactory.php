<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyImage>
 */
class PropertyImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::inRandomOrder()->first()->id ?? Property::factory(),
            'image_path' => url('property_images/68d5091b049d1_placeholder.jpg'), // FULL URL
            'is_thumbnail' => $this->faker->boolean(30),
        ];
    }
}
