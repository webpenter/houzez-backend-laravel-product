<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan as PlanModel;
use App\Repositories\StripePlanRepositoryInterface;
use Stripe\Plan;
use Stripe\Product;
class StripePlanRepository implements StripePlanRepositoryInterface
{
    /**
     * Create a new plan.
     *
     * @param array $data
     * @return array
     */
    public function createPlan(array $data): array
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $plan = Plan::create([
            'amount' => $data['amount'] * 100,
            'currency' => $data['currency'],
            'interval' => $data['billing_period'],
            'interval_count' => $data['interval_count'],
            'active' => $data['active'] ? true : false,
            'product' => ['name' => $data['name']],
        ]);

        $planModel = PlanModel::create([
            'plan_id' => $plan->id,
            'name' => $data['name'],
            'price' => $plan->amount,
            'billing_method' => $plan->interval,
            'currency' => $plan->currency,
            'interval_count' => $plan->interval_count,
            'number_of_listings' => $data['number_of_listings'],
            'number_of_images' => $data['number_of_images'],
            'active' => $data['active'] ? true : false,
        ]);

        return ['plan' => $plan, 'plan_model' => $planModel];
    }

    /**
     * Update an existing plan.
     *
     * @param string $id
     * @param array $data
     * @return array
     */
    public function updatePlan(string $id, array $data): array
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $plan = Plan::retrieve($id);

        $product = Product::retrieve($plan->product);
        $product->name = $data['name'];
        $product->save();

        $plan->active = $data['active'] ? true : false;
        $plan->save();

        $planModel = PlanModel::where('plan_id', $id)->firstOrFail();

        $planModel->update([
            'name' => $data['name'],
            'number_of_listings' => $data['number_of_listings'],
            'number_of_images' => $data['number_of_images'],
            'active' => $data['active'] ? true : false,
        ]);

        return ['plan' => $plan, 'plan_model' => $planModel];
    }
}
