<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        UserProfile::create([
            'user_id' => User::where('username', 'admin')->first()->id,
            'public_name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'title' => 'Mr.',
            'position' => 'System Administrator',
            'license' => null,
            'mobile' => '+1-555-010-1000',
            'whatsapp' => null,
            'phone' => '+1-555-010-1001',
            'fax_number' => null,
            'company_name' => null,
            'address' => '123 Admin St, System City, SC 12345',
            'tax_number' => null,
            'service_areas' => 'System-wide',
            'specialties' => 'Administration, System Management',
            'about_me' => 'I manage the system and ensure smooth operations for all users.',
            'profile_picture' => null,
            'facebook' => null,
            'twitter' => null,
            'linkedin' => 'https://linkedin.com/in/admin-user',
            'instagram' => null,
            'google_plus' => null,
            'youtube' => null,
            'pinterest' => null,
            'vimeo' => null,
            'skype' => 'admin.user',
            'website' => null,
        ]);

        // Agency User
        UserProfile::create([
            'user_id' => User::where('username', 'agency')->first()->id,
            'public_name' => 'Agency One',
            'first_name' => 'Agency',
            'last_name' => 'One',
            'title' => null,
            'position' => 'Agency Owner',
            'license' => 'AGY-123456',
            'mobile' => '+1-555-020-2000',
            'whatsapp' => '+1-555-020-2000',
            'phone' => '+1-555-020-2001',
            'fax_number' => '+1-555-020-2002',
            'company_name' => 'Agency One Real Estate',
            'address' => '456 Agency Ave, Business City, BC 67890',
            'tax_number' => '12-3456789',
            'service_areas' => 'Business City, Downtown, Suburbs',
            'specialties' => 'Commercial Real Estate, Property Management, Leasing',
            'about_me' => 'Agency One provides top-tier real estate services, specializing in commercial properties and leasing.',
            'profile_picture' => 'https://example.com/agency_one.jpg',
            'facebook' => 'https://facebook.com/agencyone',
            'twitter' => 'https://twitter.com/agencyone',
            'linkedin' => 'https://linkedin.com/company/agency-one',
            'instagram' => 'https://instagram.com/agencyone',
            'google_plus' => null,
            'youtube' => null,
            'pinterest' => null,
            'vimeo' => null,
            'skype' => null,
            'website' => 'https://agencyone.com',
        ]);

        // Agent (John Doe)
        UserProfile::create([
            'user_id' => User::where('username', 'john_doe11')->first()->id,
            'public_name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'title' => 'Mr.',
            'position' => 'Real Estate Agent',
            'license' => 'AGT-789012',
            'mobile' => '+1-555-030-3000',
            'whatsapp' => '+1-555-030-3000',
            'phone' => '+1-555-030-3001',
            'fax_number' => null,
            'company_name' => 'Agency One Real Estate',
            'address' => '456 Agency Ave, Business City, BC 67890',
            'tax_number' => null,
            'service_areas' => 'Downtown, East Side',
            'specialties' => 'Residential Sales, First-Time Buyers',
            'about_me' => 'Passionate about helping clients find their dream homes with personalized service.',
            'profile_picture' => 'https://example.com/john_doe.jpg',
            'facebook' => 'https://facebook.com/johndoe',
            'twitter' => null,
            'linkedin' => 'https://linkedin.com/in/johndoe',
            'instagram' => 'https://instagram.com/johndoe',
            'google_plus' => null,
            'youtube' => null,
            'pinterest' => null,
            'vimeo' => null,
            'skype' => 'john.doe',
            'website' => null,
        ]);

        // Agent (Jane Smith)
        UserProfile::create([
            'user_id' => User::where('username', 'jane_smith')->first()->id,
            'public_name' => 'Jane Smith',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'title' => 'Ms.',
            'position' => 'Independent Real Estate Agent',
            'license' => 'AGT-345678',
            'mobile' => '+1-555-040-4000',
            'whatsapp' => '+1-555-040-4000',
            'phone' => '+1-555-040-4001',
            'fax_number' => null,
            'company_name' => 'Jane Smith Realty',
            'address' => '789 Freelance Rd, Freedom City, FC 54321',
            'tax_number' => '98-7654321',
            'service_areas' => 'Freedom City, West Side',
            'specialties' => 'Luxury Homes, Relocation Services',
            'about_me' => 'Independent agent specializing in luxury properties and seamless relocations.',
            'profile_picture' => 'https://example.com/jane_smith.jpg',
            'facebook' => 'https://facebook.com/janesmith',
            'twitter' => 'https://twitter.com/janesmith',
            'linkedin' => 'https://linkedin.com/in/janesmith',
            'instagram' => 'https://instagram.com/janesmith',
            'google_plus' => null,
            'youtube' => 'https://youtube.com/janesmith',
            'pinterest' => null,
            'vimeo' => null,
            'skype' => null,
            'website' => 'https://janesmithrealty.com',
        ]);

        // Client User
        UserProfile::create([
            'user_id' => User::where('username', 'client_user')->first()->id,
            'public_name' => 'Client User',
            'first_name' => 'Client',
            'last_name' => 'User',
            'title' => null,
            'position' => null,
            'license' => null,
            'mobile' => '+1-555-050-5000',
            'whatsapp' => null,
            'phone' => '+1-555-050-5001',
            'fax_number' => null,
            'company_name' => null,
            'address' => '101 Client Ln, Home City, HC 98765',
            'tax_number' => null,
            'service_areas' => null,
            'specialties' => null,
            'about_me' => 'Looking for the perfect home to start a new chapter.',
            'profile_picture' => null,
            'facebook' => null,
            'twitter' => null,
            'linkedin' => null,
            'instagram' => null,
            'google_plus' => null,
            'youtube' => null,
            'pinterest' => null,
            'vimeo' => null,
            'skype' => null,
            'website' => null,
        ]);
    }
}
