<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User; // Import User if needed for user_id

class PropertyFactory extends Factory
{
    protected $model = \App\Models\Property::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(2); // Unique title to help with slugs

        return [
            'title' => $title,
            // 'slug' is handled by the model's boot method, so no need here
            'description' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement(['villa', 'apartment', 'house', 'condo', 'townhouse']),
            'status' => $this->faker->randomElement(['for_sale', 'for_rent', 'sold', 'rented']),
            'label' => $this->faker->randomElement(['featured', 'new', 'hot', 'sold', null]),
            'price' => $this->faker->randomFloat(2, 50000, 5000000),
            'second_price' => $this->faker->randomFloat(2, 10000, 1000000),
            'after_price' => $this->faker->randomElement(['month', 'year', null]),
            'price_prefix' => $this->faker->randomElement(['$', '€', '£']),
            'user_id' => User::inRandomOrder()->first()->id ?? 1, // Requires at least one user; seed users first if needed
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'garages' => $this->faker->numberBetween(0, 3),
            'garages_size' => $this->faker->optional()->randomElement(['200 sq ft', '300 sq ft', '400 sq ft']),
            'area_size' => $this->faker->numberBetween(500, 5000),
            'size_prefix' => $this->faker->randomElement(['sq ft', 'sq m']),
            'land_area' => $this->faker->optional()->numberBetween(1000, 10000),
            'land_area_size_postfix' => $this->faker->optional()->randomElement(['sq ft', 'sq m']),
            'property_id' => 'PROP-' . strtoupper(Str::random(6)),
            'year_built' => $this->faker->numberBetween(1900, date('Y')),
            'property_feature' => $this->faker->randomElements(['pool', 'gym', 'balcony', 'fireplace', 'garden', 'elevator', 'laundry'], $this->faker->numberBetween(1, 5)),
            'energy_class' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'global_energy_performance_index' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'renewable_energy_performance_index' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'energy_performance_of_the_building' => $this->faker->randomElement(['Excellent', 'Good', 'Average', 'Poor']),
            'address' => $this->faker->streetAddress,
            'country' => $this->faker->country,
            'county_state' => $this->faker->state,
            'city' => $this->faker->city,
            'neighborhood' => $this->faker->optional()->citySuffix,
            'zip_postal_code' => $this->faker->postcode,
            'map_street_view' => $this->faker->optional(0.2)->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'video_url' => '<iframe width="730" height="387" src="https://www.youtube.com/embed/cuGfG0J1aIw" frameborder="0" allowfullscreen></iframe>',
            'virtual_tour' => '<iframe width="853" height="480" src="https://my.matterport.com/show/?m=zEWsxhZpGba&play=1&qs=1" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',

            'contact_information' => [
                'phone' => $this->faker->optional()->phoneNumber,
                'email' => $this->faker->optional()->email,
            ],
            'private_note' => $this->faker->optional(0.2)->paragraph,
            // 'property_status' => $this->faker->randomElement(['published', 'pending', 'expired', 'draft', 'on_hold', 'disapproved']),
            'property_status' => $this->faker->randomElement(['published']),
            'is_paid' => $this->faker->boolean(50),
            'is_featured' => $this->faker->boolean(100),
            'views' => $this->faker->numberBetween(0, 10000),
            'unique_views' => $this->faker->numberBetween(0, 8000),
        ];
    }
}
