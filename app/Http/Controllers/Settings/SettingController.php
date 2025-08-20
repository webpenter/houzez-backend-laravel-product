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

    $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');
    return response()->json(['social_media' => $settings]);
}

public function updateSocialMedia(Request $request)
{
    $data = $request->only([
        'facebook', 'twitter', 'linkedin', 'instagram',
        'google_plus', 'youtube', 'pinterest', 'vimeo',
        'skype', 'website'
    ]);

    foreach ($data as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => 'url', 'is_visible' => true]
        );
    }

    return response()->json(['message' => 'Social Media updated successfully!']);
}
}
