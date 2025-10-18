<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name'        => 'John Doe',
            'designation' => 'CEO',
            'image'       => 'https://plus.unsplash.com/premium_photo-1678197937465-bdbc4ed95815?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8cGVyc29ufGVufDB8fDB8fHww',
            'address'     => '123 Business Street, New York, USA',
            'email'       => 'john.doe@example.com',
            'phone'       => '+1 234 567 890',
        ]);

        Team::create([
            'name'        => 'Jane Smith',
            'designation' => 'CTO',
            'image'       => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fHBlcnNvbnxlbnwwfHwwfHx8MA%3D%3D',
            'address'     => '456 Tech Avenue, San Francisco, USA',
            'email'       => 'jane.smith@example.com',
            'phone'       => '+1 987 654 321',
        ]);

        Team::create([
            'name'        => 'Michael Brown',
            'designation' => 'Project Manager',
            'image'       => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fHBlcnNvbnxlbnwwfHwwfHx8MA%3D%3D',
            'address'     => '789 Startup Road, Los Angeles, USA',
            'email'       => 'michael.brown@example.com',
            'phone'       => '+1 111 222 333',
        ]);
    }
}
