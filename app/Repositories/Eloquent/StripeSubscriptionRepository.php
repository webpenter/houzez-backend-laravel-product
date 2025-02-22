<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan as PlanModel;
use App\Models\User;
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

    /**
     * Process subscription logic.
     *
     * @param User $user
     * @param string|null $paymentMethod
     * @param string $plan
     * @return array
     */
    public function process(User $user, ?string $paymentMethod, string $plan): array
    {
        $user->createOrGetStripeCustomer();

        if ($paymentMethod) {
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }

        try {
            $user->newSubscription('default', $plan)
                ->create($paymentMethod ? $paymentMethod->id : null);

            return [
                'success' => true,
                'message' => 'Subscription has been successfully processed',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Subscription failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}
