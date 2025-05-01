<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enquiry\StoreEnquiryRequest;
use App\Http\Resources\Enquiry\EnquiryResource;
use App\Services\EnquiryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    use ResponseTrait;

    protected EnquiryService $enquiryService;

    public function __construct(EnquiryService $enquiryService)
    {
        $this->enquiryService = $enquiryService;
    }

    /**
     * Display a listing of enquiries.
     */
    public function index(): JsonResponse
    {
        $enquiries = $this->enquiryService->getAll();
        return $this->successResponse(EnquiryResource::collection($enquiries), 'Enquiries fetched successfully');
    }

    /**
     * Store a newly created enquiry.
     */
    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        $enquiry = $this->enquiryService->store($request->validated());
        return $this->successResponse(new EnquiryResource($enquiry), 'Enquiry created successfully');
    }

    /**
     * Display the specified enquiry.
     */
    public function show(int $id): JsonResponse
    {
        $enquiry = $this->enquiryService->getById($id);

        if (!$enquiry) {
            return $this->errorResponse('Enquiry not found', 404);
        }

        return $this->successResponse(new EnquiryResource($enquiry), 'Enquiry details');
    }

    /**
     * Remove the specified enquiry.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->enquiryService->delete($id);

        if (!$deleted) {
            return $this->errorResponse('Enquiry not found', 404);
        }

        return $this->successResponse(null, 'Enquiry deleted successfully');
    }
}
