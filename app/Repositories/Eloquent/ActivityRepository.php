<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Activity\ReviewResource;
use App\Repositories\ActivityRepositoryInterface;
use App\Models\Deal;
use App\Models\Enquiry;
use App\Models\Lead;
use App\Models\Review;
use Illuminate\Support\Carbon;
class ActivityRepository implements ActivityRepositoryInterface
{
    /**
     * Get all reviews of the logged-in user.
     */
    public function getUserReviews(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $userId = auth()->id();

        $reviews = Review::where('user_id', $userId)
            ->with('property')
            ->latest()
            ->take(10)
            ->get();

        return ReviewResource::collection($reviews);
    }

    /**
     * Get summary of leads.
     */
    public function getLeadsSummary(): array
    {
        $now = Carbon::now();

        $count24h = Lead::where('created_at', '>=', $now->copy()->subHours(24))->count();
        $count7d  = Lead::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $count30d = Lead::where('created_at', '>=', $now->copy()->subDays(30))->count();

        $prev24h = Lead::whereBetween('created_at', [$now->copy()->subHours(48), $now->copy()->subHours(24)])->count();
        $prev7d  = Lead::whereBetween('created_at', [$now->copy()->subDays(14), $now->copy()->subDays(7)])->count();
        $prev30d = Lead::whereBetween('created_at', [$now->copy()->subDays(60), $now->copy()->subDays(30)])->count();

        return [
            'last_24_hours' => [
                'count'  => $count24h,
                'change' => $this->calculateChange($prev24h, $count24h),
            ],
            'last_7_days' => [
                'count'  => $count7d,
                'change' => $this->calculateChange($prev7d, $count7d),
            ],
            'last_30_days' => [
                'count'  => $count30d,
                'change' => $this->calculateChange($prev30d, $count30d),
            ],
        ];
    }

    /**
     * Get summary of deals.
     */
    public function getDealsSummary(): array
    {
        return $this->getStatsSummary(Deal::class);
    }

    /**
     * Get summary of enquiries.
     */
    public function getEnquiriesSummary(): array
    {
        return $this->getStatsSummary(Enquiry::class);
    }

    /**
     * Generic function to calculate count and change stats.
     */
    private function getStatsSummary(string $model): array
    {
        $now = Carbon::now();

        $getStats = function ($start, $end) use ($model) {
            $current = $model::whereBetween('created_at', [$start, $end])->count();
            $previous = $model::whereBetween('created_at', [
                $start->copy()->subDays($end->diffInDays($start)),
                $start->copy()
            ])->count();

            $change = $previous > 0
                ? round((($current - $previous) / $previous) * 100)
                : ($current > 0 ? 100 : 0);

            return ['count' => $current, 'change' => $change];
        };

        return [
            'last_24_hours' => $getStats($now->copy()->subDay(), $now),
            'last_7_days'   => $getStats($now->copy()->subDays(7), $now),
            'last_30_days'  => $getStats($now->copy()->subDays(30), $now),
        ];
    }

    /**
     * Calculate percentage change between previous and current.
     */
    private function calculateChange(int $previous, int $current): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
