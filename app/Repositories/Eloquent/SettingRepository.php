<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class SettingRepository implements SettingRepositoryInterface
{
    protected $model;

    /**
     * SettingRepository constructor.
     *
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch a setting value by key.
     *
     * @param string $key
     * @return string|null
     * @throws InvalidArgumentException
     */
    public function getByKey(string $key): ?string
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Setting key cannot be empty.');
        }

        return $this->model->where('key', $key)->value('value');
    }

    /**
     * Update or create a setting.
     *
     * @param string $key
     * @param array $data
     * @return Setting
     * @throws InvalidArgumentException
     */
    public function updateOrCreate(string $key, array $data): Setting
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Setting key cannot be empty.');
        }

        return $this->model->updateOrCreate(
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
     *
     * @param array $keys
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function getByKeys(array $keys): Collection
    {
        if (empty($keys)) {
            throw new InvalidArgumentException('Keys array cannot be empty.');
        }

        return $this->model->whereIn('key', $keys)->get();
    }

    /**
     * Update multiple settings.
     *
     * @param array $data
     * @param array $allowedKeys
     * @param string $type
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateMultiple(array $data, array $allowedKeys, string $type): void
    {
        if (empty($data) || empty($allowedKeys)) {
            throw new InvalidArgumentException('Data or allowed keys cannot be empty.');
        }

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
