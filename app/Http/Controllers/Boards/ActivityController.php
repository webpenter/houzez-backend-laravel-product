<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    use ResponseTrait;

    protected ActivityRepositoryInterface $activityRepo;

    /**
     * Inject ActivityRepositoryInterface
     */
    public function __construct(ActivityRepositoryInterface $activityRepo)
    {
        $this->activityRepo = $activityRepo;
    }

    /**
     * Get all reviews of the logged-in user.
     *
     * @return JsonResponse
     */
    public function myReviews(): JsonResponse
    {
        $reviews = $this->activityRepo->getUserReviews();
        return $this->successResponse($reviews, 'User reviews fetched successfully.');
    }

    /**
     * Get leads summary with counts and percentage changes.
     *
     * @return JsonResponse
     */
    public function getLeadsSummary(): JsonResponse
    {
        $summary = $this->activityRepo->getLeadsSummary();
        return $this->successResponse($summary, 'Leads summary retrieved.');
    }

    /**
     * Get deals summary.
     *
     * @return JsonResponse
     */
    public function getDealsSummary(): JsonResponse
    {
        $summary = $this->activityRepo->getDealsSummary();
        return $this->successResponse($summary, 'Deals summary retrieved.');
    }

    /**
     * Get enquiries summary.
     *
     * @return JsonResponse
     */
    public function getEnquiriesSummary(): JsonResponse
    {
        $summary = $this->activityRepo->getEnquiriesSummary();
        return $this->successResponse($summary, 'Enquiries summary retrieved.');
    }
}
