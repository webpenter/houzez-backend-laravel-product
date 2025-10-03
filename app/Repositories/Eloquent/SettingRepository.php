<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    /**
     * Fetch a setting value by key.
     */
    public function getByKey(string $key): ?string
    {
        return Setting::where('key', $key)->value('value');
    }

    /**
     * Update or create a setting.
     */
    public function updateOrCreate(string $key, array $data): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $data['value'] ?? '',
                'type' => $data['type'] ?? 'string',
                'is_visible' => isset($data['is_visible']) ? (bool) $data['is_visible'] : true
            ]
        );
    }

    /**
     * Fetch settings by multiple keys.
     */
    public function getByKeys(array $keys): Collection
    {
        return Setting::whereIn('key', $keys)->get();
    }

    /**
     * Update multiple settings.
     */
    public function updateMultiple(array $data, array $allowedKeys, string $type): void
    {
        foreach ($data as $key => $item) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            $this->updateOrCreate($key, [
                'value' => $item['value'] ?? ($type === 'text' ? $item : ''),
                'type' => $type,
                'is_visible' => isset($item['is_visible']) ? (bool) $item['is_visible'] : true
            ]);
        }
    }
}
