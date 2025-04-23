<?php

// app/Repositories/GeneralSettingRepository.php
namespace App\Repositories\Eloquent;

use App\Http\Requests\Settings\StoreGeneralSettingRequest;
use App\Http\Resources\Settings\GeneralSettingResource;
use App\Models\GeneralSetting;
use App\Repositories\GeneralSettingRepositoryInterface;

/**
 * Class GeneralSettingRepository
 *
 * Handles retrieval and update operations for general site settings.
 * Implements the GeneralSettingRepositoryInterface.
 */
class GeneralSettingRepository implements GeneralSettingRepositoryInterface
{
    /**
     * Retrieve the first (and only) general settings record.
     *
     * @return GeneralSettingResource
     */
    public function get()
    {
        $setting = GeneralSetting::first();
        return new GeneralSettingResource($setting);
    }

    /**
     * Update or create the general settings.
     * - Validates incoming data using the request class.
     * - Handles file uploads for logo, background image, and hero image.
     * - Stores uploaded files in the `public/site-images` directory.
     * - Saves the full URL path to the database for each image.
     *
     * @param StoreGeneralSettingRequest $request
     * @return GeneralSettingResource
     */
    public function update(StoreGeneralSettingRequest $request)
    {
        // Get existing settings or create a new instance
        $setting = GeneralSetting::first();

        if (!$setting) {
            $setting = new GeneralSetting();
        }

        // Get validated data
        $data = $request->validated();

        // Handle image uploads
        foreach (['logo', 'bg_image', 'hero_image'] as $field) {
            if ($request->hasFile($field)) {
                $filename = time() . '_' . $request->file($field)->getClientOriginalName();

                // Move the uploaded file to the 'public/site-images' directory
                $request->file($field)->move(public_path('site-images'), $filename);

                // Save the full URL to the file in the database
                $data[$field] = url('site-images/' . $filename);
            }
        }

        // Fill the setting model with updated data and save it
        $setting->fill($data)->save();

        return new GeneralSettingResource($setting);
    }
}
