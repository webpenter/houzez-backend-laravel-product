<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Resources\StripePayment\SelectPackageResource;
use App\Http\Resources\StripePayment\UserSubscriptionsResource;
use App\Models\Plan as PlanModel;
use App\Repositories\StripeSubscriptionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

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

        return new JsonResponse([
            'success' => true,
            'package' => new SelectPackageResource($plan),
            'intent' => auth()->user()->createSetupIntent()
        ], 200);
    }

    /**
     * Process Subscription
     *
     * This method handles the subscription request by forwarding
     * the necessary data to the SubscriptionRepository.
     *
     * @param $request - The incoming HTTP request containing user data, payment method, and plan ID.
     *
     * @return JsonResponse - A JSON response indicating success or failure.
     */
    public function process(Request $request): JsonResponse
    {
        $response = $this->subscriptionRepository->process(
            $request->user(),
            $request->payment_method,
            $request->plan_id
        );

        return new JsonResponse($response, $response['success'] ? 200 : 500);
    }

    /**
     * Get User Subscriptions
     *
     * This method fetches all subscriptions for the authenticated user.
     *
     * Response Format:
     * - `success` (boolean): Indicates whether the request was successful.
     * - `subscriptions` (array): List of user subscriptions.
     *   - `items` (array): List of subscription items.
     *   - `plan` (object|null): Subscription plan details.
     *
     * @return JsonResponse
     */
    public function getUserSubscriptions(): JsonResponse
    {
        $subscriptions = Subscription::whereUserId(auth()->id())->latest()->get();

        return new JsonResponse([
            'success' => true,
            'subscriptions' => UserSubscriptionsResource::collection($subscriptions)
        ],200);
    }

    /**
     * Cancel a user's subscription.
     *
     * This method retrieves the authenticated user and cancels their subscription
     * based on the provided subscription name. If the name is missing, it returns
     * an error response.
     *
     * @param Request $request The request object containing the subscription name.
     * @return JsonResponse JSON response indicating success or failure.
     */
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

    /**
     * Resume a user's subscription.
     *
     * This method retrieves the authenticated user and resumes their subscription
     * based on the provided subscription name. If the name is missing, it returns
     * an error response.
     *
     * @param Request $request The request object containing the subscription name.
     * @return JsonResponse JSON response indicating success or failure.
     */
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
