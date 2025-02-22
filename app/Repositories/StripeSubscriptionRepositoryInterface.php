<?php

namespace App\Repositories;

use App\Models\Plan as PlanModel;
use App\Models\User;

interface StripeSubscriptionRepositoryInterface
{
    /**
     * Find a plan by its plan ID.
     *
     * @param int $planId The ID of the plan.
     * @return PlanModel|null Returns the plan model or null if not found.
     */
    public function findByPlanId(string $planId): ?PlanModel;

    /**
     * Process subscription.
     *
     * @param User $user
     * @param string|null $paymentMethod
     * @param string $plan
     * @return array
     */
    public function process(User $user, ?string $paymentMethod, string $plan): array;
}
