<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Resources\StripePayment\SelectPackageResource;
use App\Models\Plan as PlanModel;
use App\Repositories\StripeSubscriptionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private StripeSubscriptionRepositoryInterface $subscriptionRepository;

    public function __construct(StripeSubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle the checkout process.
     *
     * @param int $id The ID of the plan.
     * @return JsonResponse Returns a JSON response with the package details and payment intent.
     */
    public function checkout(string $planId): JsonResponse
    {
        $plan = $this->subscriptionRepository->findByPlanId($planId);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'package' => new SelectPackageResource($plan),
            'intent' => auth()->user()->createSetupIntent()
        ], 200);
    }

}
