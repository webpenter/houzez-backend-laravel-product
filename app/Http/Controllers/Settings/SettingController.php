<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; // ✅ correct

class SettingController extends Controller
{
    /**
     * Fetch logo from settings table
     */
    public function getLogo()
    {
        $logo = Setting::where('key', 'logo')->value('value');

        return response()->json([
            'logo' => $logo ? url($logo) : null
        ], 200);
    }

    /**
     * Update logo in settings table
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Save file
        $fileName = 'logo-' . time() . '.' . $request->logo->extension();
        $request->logo->move(public_path('site-images'), $fileName);
        $filePath = 'site-images/' . $fileName;

        // Update or create setting
        $setting = Setting::updateOrCreate(
            ['key' => 'logo'],
            [
                'value' => $filePath,
                'type' => 'image',
                'is_visible' => true
            ]
        );

        return response()->json([
            'message' => 'Logo updated successfully',
            'logo'    => url($setting->value),
        ], 200);
    }

    /**
     * Fetch banner image from settings table
     */
    public function getBanner()
    {
        $banner = Setting::where('key', 'banner')->value('value');

        return response()->json([
            'banner' => $banner ? url($banner) : null
        ], 200);
    }

    /**
     * Update banner image in settings table
     */
    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        // Save file
        $fileName = 'banner-' . time() . '.' . $request->banner->extension();
        $request->banner->move(public_path('site-images'), $fileName);
        $filePath = 'site-images/' . $fileName;

        // Update or create setting
        $setting = Setting::updateOrCreate(
            ['key' => 'banner'],
            [
                'value' => $filePath,
                'type' => 'image',
                'is_visible' => true
            ]
        );

        return response()->json([
            'message' => 'Banner updated successfully',
            'banner'  => url($setting->value),
        ], 200);
    }

public function getSocialMedia()
{
    $keys = [
        'facebook', 'twitter', 'linkedin', 'instagram',
        'google_plus', 'youtube', 'pinterest', 'vimeo',
        'skype', 'website'
    ];

    $settings = Setting::whereIn('key', $keys)->get();

    $socialMedia = [];
    foreach ($keys as $key) {
        $setting = $settings->firstWhere('key', $key);
        $socialMedia[$key] = [
            'value' => $setting->value ?? '',
            'is_visible' => (bool) ($setting->is_visible ?? true)
        ];
    }

    return response()->json(['social_media' => $socialMedia]);
}

public function updateSocialMedia(Request $request)
{
    $data = $request->all(); // payload is directly coming, not inside 'social_media'

    // Define allowed social media keys (only these will be updated)
    $allowedKeys = [
        'facebook', 'twitter', 'linkedin', 'instagram',
        'google_plus', 'pinterest', 'skype', 'vimeo',
        'website', 'youtube'
    ];

    foreach ($data as $key => $item) {
        // Skip non-social media keys
        if (!in_array($key, $allowedKeys)) {
            continue;
        }

        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value'      => $item['value'] ?? '',
                'type'       => 'url', // keep type fixed for social media
                'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
            ]
        );
    }

    return response()->json(['message' => 'Social Media updated successfully!']);
}


}
