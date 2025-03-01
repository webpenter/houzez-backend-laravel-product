<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Resources\StripePayment\SelectPackageResource;
use App\Http\Resources\StripePayment\UserSubscriptionsResource;
use App\Models\Plan as PlanModel;
use App\Models\Subscription; // Use your own Subscription model
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

    public function checkout(string $planId): JsonResponse
    {
        $plan = $this->subscriptionRepository->findByPlanId($planId);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'package' => new SelectPackageResource($plan),
            'intent' => auth()->user()->createSetupIntent()
        ], 200);
    }

    public function process(Request $request): JsonResponse
    {
        $response = $this->subscriptionRepository->process(
            $request->user(),
            $request->payment_method,
            $request->plan_id
        );

        return new JsonResponse($response, $response['success'] ? 200 : 500);
    }

    public function getUserSubscriptions(): JsonResponse
    {
        $subscriptions = Subscription::with('Plan')->where('user_id', auth()->id())->latest()->get();

        return new JsonResponse([
            'success' => true,
            'subscriptions' => UserSubscriptionsResource::collection($subscriptions)
        ], 200);
    }

    public function cancelSubscription(Request $request): JsonResponse
    {
        $name = $request->name;
        $user = auth()->user();

        if ($name) {
            $user->subscription($name)->cancel();

            return new JsonResponse([
                'success' => true,
                'message' => "Subscription has been cancelled"
            ], 200);
        }

        return new JsonResponse([
            'success' => false,
            'message' => "Subscription name is required"
        ], 400);
    }

    public function resumeSubscription(Request $request): JsonResponse
    {
        $name = $request->name;
        $user = auth()->user();

        if ($name) {
            $user->subscription($name)->resume();

            return new JsonResponse([
                'success' => true,
                'message' => "Subscription has been resumed"
            ], 200);
        }

        return new JsonResponse([
            'success' => false,
            'message' => "Subscription name is required"
        ], 400);
    }
}
