<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Requests\StripePayment\StorePlanRequest;
use App\Http\Requests\StripePayment\UpdatePlanRequest;
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

        return response()->json([
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
}
