<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key'        => 'site_name',
                'value'      => 'My Awesome App',
                'type'       => 'string',
                'is_visible' => true,
            ],
            [
                'key'        => 'logo',
                'value'      => 'https://demo03.houzez.co/wp-content/uploads/2020/02/logo-houzez-color.png',
                'type'       => 'image',
                'is_visible' => true,
            ],
            [
                'key'        => 'banner',
                'value'      => 'https://demo01.houzez.co/wp-content/themes/houzez/img/logo-houzez-white.png',
                'type'       => 'image',
                'is_visible' => true,
            ],
            [
                'key'        => 'facebook',
                'value'      => 'https://facebook.com/myapp',
                'type'       => 'url',
                'is_visible' => true,
            ],
            [
                'key'        => 'instagram',
                'value'      => 'https://instagram.com/myapp',
                'type'       => 'url',
                'is_visible' => true,
            ],
            [
                'key'        => 'email',
                'value'      => 'support@myapp.com',
                'type'       => 'string',
                'is_visible' => true,
            ],
            [
                'key'        => 'phone_number',
                'value'      => '0224325321',
                'type'       => 'string',
                'is_visible' => true,
            ],
            [
                'key'        => 'maintenance_mode',
                'value'      => '0',
                'type'       => 'boolean',
                'is_visible' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
