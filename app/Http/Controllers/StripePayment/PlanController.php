<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Requests\StripePayment\StorePlanRequest;
use App\Http\Requests\StripePayment\UpdatePlanRequest;
use App\Http\Resources\StripePayment\DashboardPlanResource;
use App\Http\Resources\StripePayment\SelectPackageResource;
use App\Repositories\StripePlanRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Stripe\Plan;
use App\Models\Plan as PlanModel;
use Stripe\Product;

class PlanController extends Controller
{
    protected $planRepository;

    /**
     * PlanController constructor.
     *
     * @param StripePlanRepositoryInterface $planRepository
     */
    public function __construct(StripePlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     * Get all plans.
     *
     * This method retrieves all plans from the plan repository
     * and returns them as a JSON response.
     *
     * @return JsonResponse
     */
    public function getAllPlans(): JsonResponse
    {
        $result = $this->planRepository->getAllPlans();

        return new JsonResponse([
            'success' => true,
            'plans' => DashboardPlanResource::collection($result),
        ]);
    }

    /**
     * Get select plans.
     *
     * This method retrieves all active plans from the plan repository
     * and returns them as a JSON response.
     *
     * @return JsonResponse
     */
    public function getSelectPlans(): JsonResponse
    {
        $result = $this->planRepository->getSelectPlans();

        return new JsonResponse([
            'success' => true,
            'plans' => SelectPackageResource::collection($result),
        ]);
    }

    /**
     * Store a new plan.
     *
     * @param StorePlanRequest $request
     * @return JsonResponse
     */
    public function storePlan(StorePlanRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $result = $this->planRepository->createPlan($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Plan created successfully.',
            'plan' => $result['plan'],
            'plan_model' => $result['plan_model']
        ]);
    }

    /**
     * Update an existing plan.
     *
     * @param UpdatePlanRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function updatePlan(UpdatePlanRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $result = $this->planRepository->updatePlan($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Plan updated successfully.',
            'plan' => $result['plan'],
            'plan_model' => $result['plan_model']
        ]);
    }

    /**
     * Delete a plan by its ID.
     *
     * @param int $id The ID of the plan to delete.
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function deletePlan($id): JsonResponse
    {
        try {
            $this->planRepository->deletePlan($id);
            return response()->json(['message' => 'Plan deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
