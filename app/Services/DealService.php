<?php

namespace App\Services;

use App\Repositories\DealRepositoryInterface;

class DealService
{
    public function __construct(protected DealRepositoryInterface $dealRepository) {}

    /**
     * Get deals by group (active/won/lost)
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public function getDealsByGroup(string $group)
    {
        return $this->dealRepository->getByGroup($group);
    }
}
