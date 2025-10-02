<?php

namespace Database\Seeders;

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

        // Run PropertySeeder
        $this->call(SettingSeeder::class);

        // Run PropertySeeder
        $this->call(PropertySeeder::class);

        // Run PropertyImageSeeder
        $this->call(PropertyImageSeeder::class);

        // Run SubPropertySeeder
        $this->call(SubPropertySeeder::class);

        // Run FloorPlanSeeder
        $this->call(FloorPlanSeeder::class);

        // Run TeamSeeder for team members
        $this->call(TeamSeeder::class);

        // Run BlogSeeder for real estate blogs
        $this->call(BlogSeeder::class);

        // Run ReviewSeeder for real estate blogs
        $this->call(ReviewSeeder::class);
    }
}
