<?php

namespace App\Repositories;

use App\Models\GeneralSetting;

interface GeneralSettingRepositoryInterface
{
    public function createOrUpdate(array $data): GeneralSetting;
}