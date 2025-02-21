<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Http\Resources\StripePayment\SelectPackageResource;
use App\Models\Plan as PlanModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function checkout($id): JsonResponse
    {
        $plan = PlanModel::where('plan_id', $id)->first();

        if (!$plan) {
            return new JsonResponse([
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

}
