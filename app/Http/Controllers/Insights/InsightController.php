<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use App\Repositories\InsightRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Property;
use App\Http\Resources\Demos\Demo01\Property\AppPropertyCardDemo01Resource;

use GeoIP;

class InsightController extends Controller
{
    use ResponseTrait;
    protected InsightRepositoryInterface $insightRepo;

    public function __construct(InsightRepositoryInterface $insightRepo)
    {
        $this->insightRepo = $insightRepo;
    }

    /**
     * Record a property view with device, browser, and location.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function propertyViews(string $slug): JsonResponse
    {
        return $this->insightRepo->recordPropertyView($slug);
    }

    /**
     * Fetch properties for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getInsightProperties(): JsonResponse
    {
        return $this->insightRepo->getInsightProperties();
    }

    /**
     * Calculate view stats for 24h, 7d, and 30d.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getPropertyViews(int $id): JsonResponse
    {
        return $this->insightRepo->getPropertyViews($id);
    }

    /**
     * Get unique view stats for 24h, 7d, and 30d.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getPropertyUniqueViews(int $id): JsonResponse
    {
        return $this->insightRepo->getPropertyUniqueViews($id);
    }

    /**
     * Calculate chart data for 30 days.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getChartStats(int $id): JsonResponse
    {
        return $this->insightRepo->getChartStats($id);
    }

    /**
     * Device breakdown for a property.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getDeviceStats(int $id): JsonResponse
    {
        return $this->insightRepo->getDeviceStats($id);
    }

    /**
     * Country-wise views (last 4 countries).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getCountriesStats(int $id): JsonResponse
    {
        return $this->insightRepo->getCountriesStats($id);
    }

    /**
     * Platform breakdown for a property.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getPlatformStats(int $id): JsonResponse
    {
        return $this->insightRepo->getPlatformStats($id);
    }

    /**
     * Get browser-wise view counts for a property.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getBrowsersStats(int $id): JsonResponse
    {
        $data = $this->insightRepo->getBrowsersStats($id);
        return $this->successResponse($data,'Browser statistics retrieved successfully.');
    }


    public function storeRecentView(string $slug): JsonResponse
    {
        return $this->insightRepo->storeRecentView($slug);
    }


    public function getRecentViews(): JsonResponse
    {
       
        return $this->insightRepo->getRecentViews();
    }
}
