<?php

namespace App\Repositories;

use App\Http\Requests\Settings\StoreGeneralSettingRequest;

/**
 * Interface GeneralSettingRepositoryInterface
 *
 * Defines the contract for managing general site settings.
 * Any class implementing this interface should handle logic for retrieving and updating settings.
 */
interface GeneralSettingRepositoryInterface
{
    /**
     * Retrieve the general settings.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function get();

    /**
     * Update the general settings.
     *
     * Handles file uploads and stores full URLs for images.
     *
     * @param StoreGeneralSettingRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(StoreGeneralSettingRequest $request);
}
