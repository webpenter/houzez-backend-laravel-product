<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan as PlanModel;
use App\Repositories\StripeSubscriptionRepositoryInterface;

class StripeSubscriptionRepository implements StripeSubscriptionRepositoryInterface
{
    /**
     * Find a plan by its plan ID.
     *
     * @param int $planId The ID of the plan.
     * @return PlanModel|null Returns the plan model or null if not found.
     */
    public function findByPlanId(string $planId): ?PlanModel
    {
        return PlanModel::where('plan_id', $planId)->first();
    }
}
