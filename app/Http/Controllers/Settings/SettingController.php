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

    /**
     * Get site information settings
     *
     * @return JsonResponse
     */
    public function getSiteInformation(): JsonResponse
    {
        $keys = ['email', 'phone_number', 'site_name', 'site_title'];

        $settings = Setting::whereIn('key', $keys)->get();

        $siteInfo = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $siteInfo[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['site_information' => $siteInfo], 200);
    }

    /**
     * Update site information settings
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateSiteInformation(Request $request): JsonResponse
    {
        $data = $request->all();

        $allowedKeys = ['email', 'phone_number', 'site_name', 'site_title'];

        foreach ($data as $key => $item) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $item['value'] ?? '',
                    'type'       => 'string',
                    'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
                ]
            );
        }

        return response()->json(['message' => 'Site Information updated successfully!'], 200);
    }

    /**
     * Fetch Stripe settings
     */
    public function getStripeSettings(): JsonResponse
    {
        $keys = ['stripe_public_key', 'stripe_private_key', 'currency'];

        $settings = Setting::whereIn('key', $keys)->get();

        $stripeSettings = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $stripeSettings[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['stripe' => $stripeSettings]);
    }

    /**
     * Update Stripe settings
     */
    public function updateStripeSettings(Request $request): JsonResponse
    {
        $request->validate([
            'stripe_public_key.value'  => 'required|string',
            'stripe_private_key.value' => 'required|string',
            'currency.value'           => 'required|string|max:5',
        ]);

        $data = $request->all();

        $allowedKeys = ['stripe_public_key', 'stripe_private_key', 'currency'];

        foreach ($data as $key => $item) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $item['value'] ?? '',
                    'type'       => 'string',
                    'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
                ]
            );
        }

        return response()->json(['message' => 'Stripe settings updated successfully!']);
    }

    /**
     * Fetch Contact Settings
     */
    public function getContactSettings(): JsonResponse
    {
        $keys = ['contact_email', 'contact_phone', 'address', 'mobile_number', 'whatsapp_number'];

        $settings = Setting::whereIn('key', $keys)->get();

        $contact = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $contact[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['contact' => $contact]);
    }

    /**
     * Update Contact Settings
     */
    public function updateContactSettings(Request $request): JsonResponse
    {
        $request->validate([
            'contact_email.value'     => 'nullable|email',
            'contact_phone.value'     => 'nullable|string|max:20',
            'address.value'           => 'nullable|string|max:255',
            'mobile_number.value'     => 'nullable|string|max:20',
            'whatsapp_number.value'   => 'nullable|string|max:20',
        ]);

        $data = $request->all();
        $allowedKeys = ['contact_email', 'contact_phone', 'address', 'mobile_number', 'whatsapp_number'];

        foreach ($data as $key => $item) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $item['value'] ?? '',
                    'type'       => 'string',
                    'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
                ]
            );
        }

        return response()->json(['message' => 'Contact settings updated successfully!']);
    }

    /**
     * Fetch Email Settings
     */
    public function getEmailSettings(): JsonResponse
    {
        $keys = [
            'mail_driver',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_from_address',
            'mail_from_name'
        ];

        $settings = Setting::whereIn('key', $keys)->get();

        $email = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $email[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['email_settings' => $email]);
    }

    /**
     * Update Email Settings
     */
    public function updateEmailSettings(Request $request): JsonResponse
    {
        $request->validate([
            'mail_driver.value'       => 'required|string|in:smtp,sendmail,mailgun,ses',
            'mail_host.value'         => 'nullable|string|max:191',
            'mail_port.value'         => 'nullable|numeric',
            'mail_username.value'     => 'nullable|string|max:191',
            'mail_password.value'     => 'nullable|string|max:191',
            'mail_from_address.value' => 'nullable|email',
            'mail_from_name.value'    => 'nullable|string|max:191',
        ]);

        $data = $request->all();
        $allowedKeys = [
            'mail_driver', 'mail_host', 'mail_port', 'mail_username',
            'mail_password', 'mail_from_address', 'mail_from_name'
        ];

        foreach ($data as $key => $item) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $item['value'] ?? '',
                    'type'       => 'string',
                    'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
                ]
            );
        }

        return response()->json(['message' => 'Email settings updated successfully!']);
    }

    /**
     * Fetch SEO settings from database
     */
    public function getSeoSettings(): JsonResponse
    {
        $keys = [
            'meta_title', 'meta_description', 'meta_keywords',
            'google_analytics_code', 'facebook_pixel_code'
        ];

        $settings = Setting::whereIn('key', $keys)->get();

        $seo = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $seo[$key] = $setting->value ?? '';
        }

        return response()->json(['seo' => $seo], 200);
    }

    /**
     * Update SEO settings in database
     */
    public function updateSeoSettings(Request $request): JsonResponse
    {
        $request->validate([
            'meta_title'            => 'nullable|string|max:255',
            'meta_description'      => 'nullable|string|max:500',
            'meta_keywords'         => 'nullable|string|max:500',
            'google_analytics_code' => 'nullable|string|max:1000',
            'facebook_pixel_code'   => 'nullable|string|max:1000',
        ]);

        foreach ($request->all() as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $value,
                    'type'       => 'text',
                    'is_visible' => true,
                ]
            );
        }

        return response()->json(['message' => 'SEO settings updated successfully!'], 200);
    }




}
