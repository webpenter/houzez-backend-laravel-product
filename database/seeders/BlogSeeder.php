<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([
            'title'       => 'Top 5 Tips for First-Time Home Buyers',
            'image'       => 'https://plus.unsplash.com/premium_photo-1676321688612-4451a8721435?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8cHJvcGVydGllc3xlbnwwfHwwfHx8MA%3D%3D',
            'description' => 'Buying your first home can be exciting and overwhelming. Here are five essential tips to help you make smart decisions in the real estate market.',
        ]);

        Blog::create([
            'title'       => 'Why Location Matters in Real Estate Investment',
            'image'       => 'https://images.unsplash.com/photo-1613553507747-5f8d62ad5904?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8cHJvcGVydGllc3xlbnwwfHwwfHx8MA%3D%3D',
            'description' => 'Discover why location is the most critical factor when investing in properties, and how it impacts long-term value and rental demand.',
        ]);

        Blog::create([
            'title'       => 'Modern Apartment Living: Benefits and Features',
            'image'       => 'https://plus.unsplash.com/premium_photo-1676321046449-5fc72b124490?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTN8fHByb3BlcnRpZXN8ZW58MHx8MHx8fDA%3D',
            'description' => 'Apartments offer convenience, security, and modern amenities. Explore the benefits of choosing an apartment for your next home or investment.',
        ]);

        Blog::create([
            'title'       => 'How to Increase Property Value Before Selling',
            'image'       => 'https://plus.unsplash.com/premium_photo-1684508638760-72ad80c0055f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHByb3BlcnRpZXN8ZW58MHx8MHx8fDA%3D',
            'description' => 'From home renovations to curb appeal, learn the top strategies that can significantly boost your property’s value before putting it on the market.',
        ]);

        Blog::create([
            'title'       => 'Real Estate Trends to Watch in 2025',
            'image'       => 'https://plus.unsplash.com/premium_photo-1684508638760-72ad80c0055f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHByb3BlcnRpZXN8ZW58MHx8MHx8fDA%3D',
            'description' => 'Stay ahead of the market! Explore the latest real estate trends for 2025, including smart homes, green buildings, and shifting buyer preferences.',
        ]);
    }
}
