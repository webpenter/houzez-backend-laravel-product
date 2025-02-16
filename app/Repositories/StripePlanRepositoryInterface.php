<?php

namespace App\Repositories;

interface StripePlanRepositoryInterface
{

    /**
     * Create a new plan.
     *
     * @param array $data
     * @return array
     */
    public function createPlan(array $data): array;

    /**
     * Update an existing plan.
     *
     * @param string $id
     * @param array $data
     * @return array
     */
    public function updatePlan(string $id, array $data): array;
}
