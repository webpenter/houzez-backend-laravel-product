<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'), // Securely hashed password
            'is_admin' => true,
            'role' => 'adminstrator',
        ]);

        // Create an agency user
        User::create([
            'username' => 'agency_one',
            'email' => 'agency1@gmail.com.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agency',
        ]);

        // Create a regular user (agent)
        User::create([
            'username' => 'john_doe11',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agent',
        ]);

        // Create additional users for variety
        User::create([
            'username' => 'jane_smith',
            'email' => 'jane.smith@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agent',
        ]);

        // Create a client user
        User::create([
            'username' => 'client_user',
            'email' => 'client@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'subscriber',
        ]);

    }
}
