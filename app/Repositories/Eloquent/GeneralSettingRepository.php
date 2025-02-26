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
    public function createOrUpdate(array $data): GeneralSetting
    {
        $settings = GeneralSetting::first();

        if ($settings) {
            $settings->update($data);
        } else {
            $settings = GeneralSetting::create($data);
        }
        return $settings;
    }
}