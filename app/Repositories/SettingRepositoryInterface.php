<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface SettingRepositoryInterface
{
    /**
     * Fetch a setting value by key.
     *
     * @param string $key
     * @return string|null
     */
    public function getByKey(string $key): ?string;

    /**
     * Update or create a setting.
     *
     * @param string $key
     * @param array $data
     * @return Setting
     */
    public function updateOrCreate(string $key, array $data): Setting;

    /**
     * Fetch settings by multiple keys.
     *
     * @param array $keys
     * @return Collection
     */
    public function getByKeys(array $keys): Collection;

    /**
     * Update multiple settings.
     *
     * @param array $data
     * @param array $allowedKeys
     * @param string $type
     * @return void
     */
    public function updateMultiple(array $data, array $allowedKeys, string $type): void;
}
