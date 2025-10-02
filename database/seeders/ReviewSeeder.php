<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Property;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all users and properties
        $users = User::all();
        $properties = Property::all();

        // Check if users and properties exist
        if ($users->isEmpty() || $properties->isEmpty()) {
            echo "Please ensure there are users and properties in the database before seeding reviews.";
            return;
        }

        // Hardcoded review data
        $reviews = [
            [
                'property_id' => $properties->first()->id, // Use first property
                'user_id' => $users->first()->id, // Use first user
                'email' => $users->first()->email,
                'title' => 'Amazing Stay!',
                'rating' => 5,
                'comment' => 'The property was clean, spacious, and had all the amenities we needed. Highly recommend!',
            ],
            [
                'property_id' => $properties->skip(1)->first()->id, // Use second property
                'user_id' => $users->skip(1)->first()->id, // Use second user
                'email' => $users->skip(1)->first()->email,
                'title' => 'Good Experience',
                'rating' => 4,
                'comment' => 'Great location and friendly staff, but the Wi-Fi was a bit slow.',
            ],
            [
                'property_id' => $properties->first()->id, // Use first property again
                'user_id' => $users->skip(2)->first()->id, // Use third user
                'email' => $users->skip(2)->first()->email,
                'title' => 'Decent Place',
                'rating' => 3,
                'comment' => 'The property was okay, but the parking situation could be improved.',
            ],
            [
                'property_id' => $properties->first()->id, // Use first property
                'user_id' => $users->first()->id, // Use first user
                'email' => $users->first()->email,
                'title' => 'Amazing Stay!',
                'rating' => 5,
                'comment' => 'The property was clean, spacious, and had all the amenities we needed. Highly recommend!',
            ],
            [
                'property_id' => $properties->skip(1)->first()->id, // Use second property
                'user_id' => $users->skip(1)->first()->id, // Use second user
                'email' => $users->skip(1)->first()->email,
                'title' => 'Good Experience',
                'rating' => 4,
                'comment' => 'Great location and friendly staff, but the Wi-Fi was a bit slow.',
            ],
            [
                'property_id' => $properties->first()->id, // Use first property again
                'user_id' => $users->skip(2)->first()->id, // Use third user
                'email' => $users->skip(2)->first()->email,
                'title' => 'Decent Place',
                'rating' => 3,
                'comment' => 'The property was okay, but the parking situation could be improved.',
            ],
        ];

        // Create reviews
        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }
    }
}
