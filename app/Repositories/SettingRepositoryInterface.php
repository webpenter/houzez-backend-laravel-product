<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    public function all(): Collection;
    public function get(string $key): ?Setting;
    public function updateOrCreate(array $data): Setting;

     /**
     * Get only visible social links with their icons.
     *
     * @return array
     */
    public function getVisibleSocialLinks(): array;
}
