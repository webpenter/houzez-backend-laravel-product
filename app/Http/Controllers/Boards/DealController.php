<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Http\Resources\Deal\DealResource;
use App\Repositories\DealRepositoryInterface;
use App\Services\DealService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected DealRepositoryInterface $dealRepo,
        protected DealService $dealService
    ) {}

    /**
     * List all deals
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(DealResource::collection($this->dealRepo->all()));
    }

    /**
     * Store a new deal
     *
     * @param StoreDealRequest $request
     * @return JsonResponse
     */
    public function store(StoreDealRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $deal = $this->dealRepo->create($data);
        return $this->successResponse(new DealResource($deal), 'Deal created successfully');
    }

    /**
     * Show single deal
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $deal = $this->dealRepo->find($id);
        return $this->successResponse(new DealResource($deal));
    }

    /**
     * Update deal
     *
     * @param UpdateDealRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateDealRequest $request, int $id): JsonResponse
    {
        dd('dd');

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        $deal = $this->dealRepo->update($id, $data);
        return $this->successResponse(new DealResource($deal), 'Deal updated successfully');
    }

    /**
     * Delete a deal
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->dealRepo->delete($id);
        return $this->successResponse(null, 'Deal deleted successfully');
    }

    /**
     * Get all active deals
     *
     * @return JsonResponse
     */
    public function active(): JsonResponse
    {
        return $this->successResponse(DealResource::collection($this->dealService->getDealsByGroup('active')));
    }

    /**
     * Get all won deals
     *
     * @return JsonResponse
     */
    public function won(): JsonResponse
    {
        return $this->successResponse(DealResource::collection($this->dealService->getDealsByGroup('won')));
    }

    /**
     * Get all lost deals
     *
     * @return JsonResponse
     */
    public function lost(): JsonResponse
    {
        return $this->successResponse(DealResource::collection($this->dealService->getDealsByGroup('lost')));
    }
}
