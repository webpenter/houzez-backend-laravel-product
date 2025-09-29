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
            'agency_id' => null, // Admin not tied to an agency
        ]);

        // Create an agency user
        User::create([
            'username' => 'agency_one',
            'email' => 'agency1@gmail.com.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agency',
            'agency_id' => null, // Assuming agency_id 1 exists; adjust if needed
        ]);

        // Create a regular user (agent)
        User::create([
            'username' => 'john_doe11',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agent',
            'agency_id' => User::where('role', 'agency')->first()->id,
        ]);

        // Create additional users for variety
        User::create([
            'username' => 'jane_smith',
            'email' => 'jane.smith@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'agent',
            'agency_id' => null, // Independent agent
        ]);

        // Create a client user
        User::create([
            'username' => 'client_user',
            'email' => 'client@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
            'role' => 'subscriber',
            'agency_id' => null, // Clients not tied to an agency
        ]);

    }
}
