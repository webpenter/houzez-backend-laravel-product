<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Activity\ReviewResource;
use App\Models\Deal;
use App\Models\Enquiry;
use App\Models\Lead;
use App\Models\Review;
use App\Repositories\ActivityRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class ActivityRepository implements ActivityRepositoryInterface
{
    protected $reviewModel;
    protected $leadModel;
    protected $dealModel;
    protected $enquiryModel;

    /**
     * ActivityRepository constructor.
     *
     * @param Review $reviewModel
     * @param Lead $leadModel
     * @param Deal $dealModel
     * @param Enquiry $enquiryModel
     */
    public function __construct(Review $reviewModel, Lead $leadModel, Deal $dealModel, Enquiry $enquiryModel)
    {
        $this->reviewModel = $reviewModel;
        $this->leadModel = $leadModel;
        $this->dealModel = $dealModel;
        $this->enquiryModel = $enquiryModel;
    }

    /**
     * Get all reviews of the logged-in user.
     *
     * @return AnonymousResourceCollection
     * @throws InvalidArgumentException
     */
    public function getUserReviews(): AnonymousResourceCollection
    {
        $userId = auth()->id();
        if (!$userId) {
            throw new InvalidArgumentException('User must be authenticated to fetch reviews.');
        }

        $cacheKey = "user_reviews_{$userId}";
        $reviews = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($userId) {
            return $this->reviewModel->where('user_id', $userId)
                ->with('property')
                ->latest()
                ->take(10)
                ->get();
        });

        return ReviewResource::collection($reviews);
    }

    /**
     * Get summary of leads.
     *
     * @return array
     */
    public function getLeadsSummary(): array
    {
        return $this->getStatsSummary($this->leadModel, 'leads_summary');
    }

    /**
     * Get summary of deals.
     *
     * @return array
     */
    public function getDealsSummary(): array
    {
        return $this->getStatsSummary($this->dealModel, 'deals_summary');
    }

    /**
     * Get summary of enquiries.
     *
     * @return array
     */
    public function getEnquiriesSummary(): array
    {
        return $this->getStatsSummary($this->enquiryModel, 'enquiries_summary');
    }

    /**
     * Generic function to calculate count and change stats for a model.
     *
     * @param mixed $model
     * @param string $cacheKeyPrefix
     * @return array
     * @throws InvalidArgumentException
     */
    private function getStatsSummary($model, string $cacheKeyPrefix): array
    {
        if (!method_exists($model, 'whereBetween')) {
            throw new InvalidArgumentException('Invalid model provided for stats summary.');
        }

        $now = Carbon::now();
        $cacheKey = "{$cacheKeyPrefix}_stats";

        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($model, $now) {
            $getStats = function ($start, $end) use ($model, $now) {
                $current = $model->whereBetween('created_at', [$start, $now])->count();
                $previous = $model->whereBetween('created_at', [
                    $start->copy()->subDays($end->diffInDays($start)),
                    $start
                ])->count();

                $change = $previous > 0
                    ? round((($current - $previous) / $previous) * 100, 1)
                    : ($current > 0 ? 100.0 : 0.0);

                return ['count' => $current, 'change' => $change];
            };

            return [
                'last_24_hours' => $getStats($now->copy()->subDay(), $now),
                'last_7_days' => $getStats($now->copy()->subDays(7), $now),
                'last_30_days' => $getStats($now->copy()->subDays(30), $now),
            ];
        });
    }
}
