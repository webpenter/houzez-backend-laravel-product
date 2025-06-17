<?php

namespace App\Repositories\Eloquent;

use App\Mail\PlanSubscribedMail;
use App\Models\Plan;
use App\Models\Plan as PlanModel;
use App\Models\User;
use App\Repositories\StripeSubscriptionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
//    public function process(User $user, ?string $paymentMethod, string $plan): array
//    {
//        $user->createOrGetStripeCustomer();
//
//        if ($paymentMethod) {
//            $paymentMethod = $user->addPaymentMethod($paymentMethod);
//        }
//
//        try {
//            $user->newSubscription('default', $plan)
//                ->create($paymentMethod ? $paymentMethod->id : null);
//
//            return [
//                'success' => true,
//                'message' => 'Subscription has been successfully processed',
//            ];
//        } catch (\Exception $e) {
//            return [
//                'success' => false,
//                'message' => 'Subscription failed',
//                'error' => $e->getMessage(),
//            ];
//        }
//    }
    public function process(User $user, ?string $paymentMethod, string $plan): array
    {
        $user->createOrGetStripeCustomer();

        if ($paymentMethod) {
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }

        try {
            // Subscribe
            $subscription = $user->newSubscription('default', $plan)
                ->create($paymentMethod ? $paymentMethod->id : null);

            // Get plan from DB
            $planModel = Plan::where('plan_id', $plan)->firstOrFail();

            // Get Stripe subscription info
            $stripeSubscription = $user->subscription('default')->asStripeSubscription();
            $startDate = Carbon::createFromTimestamp($stripeSubscription->current_period_start)->toDateString();
            $endDate = Carbon::createFromTimestamp($stripeSubscription->current_period_end)->toDateString();

            // Send queued email
            Mail::to($user->email)->send(new PlanSubscribedMail(
                $user,
                $planModel,
                $startDate,
                $endDate
            ));

            return [
                'success' => true,
                'message' => 'Subscription processed and email sent',
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
