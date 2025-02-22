<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface StripePlanRepositoryInterface
{
    /**
     * Get all plans.
     *
     * This method retrieves all plans from the PlanModel
     * and returns them as a collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPlans(): Collection;

    /**
     * Get select plans.
     *
     * This method retrieves all active plans from the PlanModel
     * and returns them as a collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSelectPlans(): Collection;

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

    /**
     * Delete a plan from Stripe and the database.
     *
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function deletePlan(string $id): bool;
}
