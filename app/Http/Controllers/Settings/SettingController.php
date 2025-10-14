<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\BannerSettingRequest;
use App\Http\Requests\Settings\ContactSettingRequest;
use App\Http\Requests\Settings\EmailSettingRequest;
use App\Http\Requests\Settings\LogoSettingRequest;
use App\Http\Requests\Settings\SeoSettingRequest;
use App\Http\Requests\Settings\SettingRequest;
use App\Http\Requests\Settings\SiteInformationSettingRequest;
use App\Http\Requests\Settings\SocialMediaSettingRequest;
use App\Http\Requests\Settings\StripeSettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Fetch logo from settings table
     */
    public function getLogo(): JsonResponse
    {
        $logo = $this->settingRepository->getByKey('logo');

        return response()->json([
            'logo' => $logo ? url($logo) : null
        ], 200);
    }

    /**
     * Update logo in settings table
     */
    public function updateLogo(LogoSettingRequest $request): JsonResponse
    {
        // Initialize Intervention Image manager
        $manager = new ImageManager(new Driver());

        // Original uploaded file
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();

        // Base file name (without type)
        $baseName = 'logo-' . $timestamp;

        // Define output directory
        $directory = public_path('site-images');

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // === Create multiple versions ===
        $originalPath = $directory . "/{$baseName}.{$extension}";
        $logoPath     = $directory . "/{$baseName}-logo.{$extension}";
        $bannerPath   = $directory . "/{$baseName}-banner.{$extension}";
        $thumbPath    = $directory . "/{$baseName}-thumb.{$extension}";

        // Save original image
        $file->move($directory, "{$baseName}.{$extension}");

        // Read the saved image
        $image = $manager->read($originalPath);

        // Create logo (square 200x200)
        $image->scale(width: 90, height: 125)->save($logoPath);

        // Create banner (wide)
        $manager->read($originalPath)->cover(1200, 400)->save($bannerPath);

        // Create thumbnail (small)
        $manager->read($originalPath)->scale(width: 100, height: 100)->save($thumbPath);

        // Convert to relative paths for DB
        $relativeLogoPath = 'site-images/' . basename($logoPath);

        // Update or create DB record
        $setting = $this->settingRepository->updateOrCreate('logo', [
            'value' => $relativeLogoPath,
            'type' => 'image',
            'is_visible' => true
        ]);

        // Return all versions
        return response()->json([
            'message' => 'Logo updated successfully',
            'original' => url('site-images/' . basename($originalPath)),
            'logo' => url($relativeLogoPath),
            'banner' => url('site-images/' . basename($bannerPath)),
            'thumb' => url('site-images/' . basename($thumbPath)),
        ], 200);
    }

    /**
     * Fetch banner image from settings table
     */
    public function getBanner(): JsonResponse
    {
        $banner = $this->settingRepository->getByKey('banner');

        return response()->json([
            'banner' => $banner ? url($banner) : null
        ], 200);
    }

    /**
     * Update banner image in settings table
     */
    public function updateBanner(BannerSettingRequest $request): JsonResponse
    {
        // Save file
        $fileName = 'banner-' . time() . '.' . $request->banner->extension();
        $request->banner->move(public_path('site-images'), $fileName);
        $filePath = 'site-images/' . $fileName;

        // Update or create setting
        $setting = $this->settingRepository->updateOrCreate('banner', [
            'value' => $filePath,
            'type' => 'image',
            'is_visible' => true
        ]);

        return response()->json([
            'message' => 'Banner updated successfully',
            'banner' => url($setting->value),
        ], 200);
    }

    /**
     * Fetch social media settings
     */
    public function getSocialMedia(): JsonResponse
    {
        $keys = [
            'facebook',
            'twitter',
            'linkedin',
            'instagram',
            'google_plus',
            'youtube',
            'pinterest',
            'vimeo',
            'skype',
            'website'
        ];

        $settings = $this->settingRepository->getByKeys($keys);

        $socialMedia = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $socialMedia[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['social_media' => $socialMedia], 200);
    }

    /**
     * Update social media settings
     */
    public function updateSocialMedia(SocialMediaSettingRequest $request): JsonResponse
    {
        $data = $request->all();

        $allowedKeys = [
            'facebook',
            'twitter',
            'linkedin',
            'instagram',
            'google_plus',
            'pinterest',
            'skype',
            'vimeo',
            'website',
            'youtube'
        ];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'url');

        return response()->json(['message' => 'Social Media updated successfully!'], 200);
    }

    /**
     * Fetch site information settings
     */
    public function getSiteInformation(): JsonResponse
    {
        $keys = ['email', 'phone_number', 'site_name', 'site_title'];

        $settings = $this->settingRepository->getByKeys($keys);

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
     */
    public function updateSiteInformation(SiteInformationSettingRequest $request): JsonResponse
    {
        $data = $request->all();
        $allowedKeys = ['email', 'phone_number', 'site_name', 'site_title'];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'string');

        return response()->json(['message' => 'Site Information updated successfully!'], 200);
    }

    /**
     * Fetch Stripe settings
     */
    public function getStripeSettings(): JsonResponse
    {
        $keys = ['stripe_public_key', 'stripe_private_key', 'currency'];

        $settings = $this->settingRepository->getByKeys($keys);

        $stripeSettings = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $stripeSettings[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['stripe' => $stripeSettings], 200);
    }

    /**
     * Update Stripe settings
     */
    public function updateStripeSettings(StripeSettingRequest $request): JsonResponse
    {
        $data = $request->all();
        $allowedKeys = ['stripe_public_key', 'stripe_private_key', 'currency'];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'string');

        return response()->json(['message' => 'Stripe settings updated successfully!'], 200);
    }

    /**
     * Fetch contact settings
     */
    public function getContactSettings(): JsonResponse
    {
        $keys = ['contact_email', 'contact_phone', 'address', 'mobile_number', 'whatsapp_number'];

        $settings = $this->settingRepository->getByKeys($keys);

        $contact = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $contact[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['contact' => $contact], 200);
    }

    /**
     * Update contact settings
     */
    public function updateContactSettings(ContactSettingRequest $request): JsonResponse
    {

        $data = $request->all();
        $allowedKeys = ['contact_email', 'contact_phone', 'address', 'mobile_number', 'whatsapp_number'];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'string');

        return response()->json(['message' => 'Contact settings updated successfully!'], 200);
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

        $settings = $this->settingRepository->getByKeys($keys);

        $email = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $email[$key] = [
                'value' => $setting->value ?? '',
                'is_visible' => (bool) ($setting->is_visible ?? true)
            ];
        }

        return response()->json(['email_settings' => $email], 200);
    }

    /**
     * Update Email Settings
     */
    public function updateEmailSettings(EmailSettingRequest $request): JsonResponse
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
            'mail_driver',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_from_address',
            'mail_from_name'
        ];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'string');

        return response()->json(['message' => 'Email settings updated successfully!'], 200);
    }


    /**
     * Fetch SEO settings
     */
    public function getSeoSettings(): JsonResponse
    {
        $keys = [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'google_analytics_code',
            'facebook_pixel_code'
        ];

        $settings = $this->settingRepository->getByKeys($keys);

        $seo = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $seo[$key] = $setting->value ?? '';
        }

        return response()->json(['seo' => $seo], 200);
    }

    /**
     * Update SEO settings
     */
    public function updateSeoSettings(SeoSettingRequest $request): JsonResponse
    {

        $data = $request->all();
        $allowedKeys = [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'google_analytics_code',
            'facebook_pixel_code'
        ];

        $this->settingRepository->updateMultiple($data, $allowedKeys, 'text');

        return response()->json(['message' => 'SEO settings updated successfully!'], 200);
    }
}
