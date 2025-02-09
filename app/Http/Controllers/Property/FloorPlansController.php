<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\FloorPlansRequest;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class FloorPlansController extends Controller
{
    public function createOrUpdate(FloorPlansRequest $request, $propertyId, $floorPlanId = null): JsonResponse
    {
        try {
            $property = Property::findOrFail($propertyId);

            $data = $request->validated();

            $floorPlansData = $data['floorPlans'];
            $storedFloorPlans = [];

            foreach ($floorPlansData as $floorPlan) {
                if (isset($floorPlan['plan_image']) && $floorPlan['plan_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $image = $floorPlan['plan_image'];

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $destinationPath = public_path('floorplans');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $image->move($destinationPath, $imageName);

                    $floorPlan['plan_image'] = url('floorplans/' . $imageName);
                }

                if ($floorPlanId) {
                    $existingFloorPlan = $property->floorPlans()->find($floorPlanId);

                    if ($existingFloorPlan) {
                        $existingFloorPlan->update($floorPlan);
                        $storedFloorPlans[] = $existingFloorPlan;
                    } else {
                        return response()->json([
                            'message' => 'Floor plan not found.',
                        ], 404);
                    }
                } else {
                    $floorPlan['property_id'] = $propertyId;
                    $storedFloorPlans[] = $property->floorPlans()->create($floorPlan);
                }
            }

            return response()->json([
                'message' => $floorPlanId ? 'Floor plan updated successfully!' : 'Floor plan(s) created successfully!',
                'floorPlans' => $storedFloorPlans,
            ], $floorPlanId ? 200 : 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
