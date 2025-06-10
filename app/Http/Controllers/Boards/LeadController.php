<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\LeadRequest;
use App\Http\Resources\Lead\LeadResource;
use App\Services\LeadService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Lead Management
 */
class LeadController extends Controller
{
    use ResponseTrait;

    protected LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Get all leads
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $leads = $this->leadService->getAllLeads();
        return $this->successResponse(LeadResource::collection($leads));
    }

    /**
     * Store a new lead
     *
     * @param LeadRequest $request
     * @return JsonResponse
     */
    public function store(LeadRequest $request): JsonResponse
    {
        $lead = $this->leadService->createLead($request->validated());
        return $this->successResponse(new LeadResource($lead), 'Lead created successfully', 201);
    }

    /**
     * Show a single lead
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $lead = $this->leadService->getLeadById($id);
        return $this->successResponse(new LeadResource($lead));
    }

    /**
     * Update a lead
     *
     * @param LeadRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(LeadRequest $request, int $id): JsonResponse
    {
        $lead = $this->leadService->updateLead($id, $request->validated());
        return $this->successResponse(new LeadResource($lead), 'Lead updated successfully');
    }

    /**
     * Delete a lead
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->leadService->deleteLead($id);
        return $this->successResponse(null, 'Lead deleted successfully');
    }
}
