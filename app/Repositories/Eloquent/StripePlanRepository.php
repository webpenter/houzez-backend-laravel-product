<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan as PlanModel;
use App\Repositories\StripePlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Stripe\Plan;
use Stripe\Product;
class StripePlanRepository implements StripePlanRepositoryInterface
{
    /**
     * Get all plans.
     *
     * This method retrieves all plans from the PlanModel
     * and returns them as a collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPlans(): Collection
    {
        return PlanModel::query()
            ->latest()
            ->get();
    }

    /**
     * Get select plans.
     *
     * This method retrieves all active plans from the PlanModel
     * and returns them as a collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSelectPlans(): Collection
    {
        return PlanModel::query()
            ->whereActive(true)
            ->latest()
            ->get();
    }

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
            'amount' => $data['amount'],
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

    /**
     * Delete a plan from Stripe and the database.
     *
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function deletePlan(string $id): bool
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $planModel = PlanModel::where('plan_id', $id)->firstOrFail();

        try {
            // Delete the plan from Stripe
            $plan = Plan::retrieve($id);
            $plan->delete();

            // Delete the plan from the database
            $planModel->delete();

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete plan: ' . $e->getMessage());
        }
    }
}
