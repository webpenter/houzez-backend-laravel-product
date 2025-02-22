<?php

namespace App\Repositories\Eloquent;

use App\Models\GeneralSetting;
use App\Repositories\GeneralSettingRepositoryInterface;

class GeneralSettingRepository implements GeneralSettingRepositoryInterface
{
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