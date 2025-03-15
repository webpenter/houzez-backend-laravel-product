<?php

namespace App\Repositories\Eloquent;

use App\Models\GeneralSetting;
use App\Repositories\GeneralSettingRepositoryInterface;

class GeneralSettingRepository implements GeneralSettingRepositoryInterface
{
    /**
     * ## Get Settings
     *
     * Retrieves the general settings.
     *
     * @return GeneralSetting|null The general settings model or null if not found.
     */
    public function getSettings(): ?GeneralSetting
    {
        return GeneralSetting::first(); // ✅ Fetches the first settings record
    }

    
    /**
     * ## Create or Update Settings
     *
     * Creates or updates the general settings.
     *
     * @param array $data The validated settings data.
     * @return GeneralSetting The created or updated general settings model.
     */
    public function createOrUpdateGeneralSettings(array $data): GeneralSetting
    {
        $settings = GeneralSetting::first();

        // Store the old logo path before updating
        $oldSiteLogo = $settings?->site_logo;
        $oldHeroImage = $settings?->hero_section_image;

        // Handle site_logo upload
        if (isset($data['site_logo']) && $data['site_logo'] instanceof \Illuminate\Http\UploadedFile) {
            $siteLogoName = time() . '_' . $data['site_logo']->getClientOriginalName();
            $data['site_logo']->move(public_path('site-logo'), $siteLogoName);
            $data['site_logo'] = url('site-logo/' . $siteLogoName); // Save the path in the database

            // Delete old logo if it exists
            if ($oldSiteLogo && file_exists(public_path($oldSiteLogo))) {
                unlink(public_path($oldSiteLogo));
            }
        }

        // Handle hero_section_image upload
        if (isset($data['hero_section_image']) && $data['hero_section_image'] instanceof \Illuminate\Http\UploadedFile) {
            $heroImageName = time() . '_' . $data['hero_section_image']->getClientOriginalName();
            $data['hero_section_image']->move(public_path('hero-section'), $heroImageName);
            $data['hero_section_image'] = url('hero-section/' . $heroImageName);

            // Delete old hero image if it exists
            if ($oldHeroImage && file_exists(public_path($oldHeroImage))) {
                unlink(public_path($oldHeroImage));
            }
        }

        // Update or create settings
        if ($settings) {
            $settings->update($data);
        } else {
            $settings = GeneralSetting::create($data);
        }

        return $settings;
    }

}