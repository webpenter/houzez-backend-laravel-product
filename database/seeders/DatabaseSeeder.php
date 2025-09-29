<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Run UserSeeder first to create users
        $this->call([
            UserSeeder::class,
            UserProfileSeeder::class,
        ]);

        // Run PropertySeeder first (assuming it's already created)
        $this->call(PropertySeeder::class);

        // Then run SubPropertySeeder
        $this->call(SubPropertySeeder::class);

        // Run FloorPlanSeeder to create floor plans
        $this->call(FloorPlanSeeder::class);
    }
}
