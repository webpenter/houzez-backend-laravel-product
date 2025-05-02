<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Resources\Activity\ReviewResource;
use App\Models\Deal;
use App\Models\Enquiry;
use App\Models\Lead;
use App\Models\Review;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ActivityControllerTest extends Controller
{
    use ResponseTrait;
    /**
     * Get all reviews of the logged-in user.
     *
     * @return JsonResponse
     */
    public function myReviews(): JsonResponse
    {
        $userId = auth()->id();

        $reviews = Review::where('user_id', $userId)
            ->with('property')
            ->latest()
            ->take(10)
            ->get();

        return $this->successResponse(ReviewResource::collection($reviews), 'User reviews fetched successfully.');
    }

    /**
     * Get leads summary with counts and percentage changes.
     *
     * @return JsonResponse
     */
    public function getLeadsSummary(): JsonResponse
    {
        $now = Carbon::now();

        $count24h = Lead::where('created_at', '>=', $now->copy()->subHours(24))->count();
        $count7d  = Lead::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $count30d = Lead::where('created_at', '>=', $now->copy()->subDays(30))->count();

        $prev24h = Lead::whereBetween('created_at', [
            $now->copy()->subHours(48),
            $now->copy()->subHours(24)
        ])->count();

        $prev7d = Lead::whereBetween('created_at', [
            $now->copy()->subDays(14),
            $now->copy()->subDays(7)
        ])->count();

        $prev30d = Lead::whereBetween('created_at', [
            $now->copy()->subDays(60),
            $now->copy()->subDays(30)
        ])->count();

        $data = [
            'last_24_hours' => [
                'count' => $count24h,
                'change' => $this->calculatePercentageChange($prev24h, $count24h),
            ],
            'last_7_days' => [
                'count' => $count7d,
                'change' => $this->calculatePercentageChange($prev7d, $count7d),
            ],
            'last_30_days' => [
                'count' => $count30d,
                'change' => $this->calculatePercentageChange($prev30d, $count30d),
            ],
        ];

        return $this->successResponse($data,'Leads summary retrieved');
    }

    /**
     * Calculate percentage change.
     */
    private function calculatePercentageChange(int $previous, int $current): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function getDealsSummary(): JsonResponse
    {
        $now = Carbon::now();

        $getStats = function ($start, $end) {
            $current = Deal::whereBetween('created_at', [$start, $end])->count();
            $previous = Deal::whereBetween('created_at', [
                $start->copy()->subDays($end->diffInDays($start)),
                $start->copy()
            ])->count();

            $change = $previous > 0
                ? round((($current - $previous) / $previous) * 100)
                : ($current > 0 ? 100 : 0);

            return ['count' => $current, 'change' => $change];
        };

        return response()->json([
            'last_24_hours' => $getStats($now->copy()->subDay(), $now),
            'last_7_days'   => $getStats($now->copy()->subDays(7), $now),
            'last_30_days'  => $getStats($now->copy()->subDays(30), $now),
        ]);
    }

    public function getEnquiriesSummary(): JsonResponse
    {
        $now = Carbon::now();

        $getStats = function ($start, $end) {
            $current = Enquiry::whereBetween('created_at', [$start, $end])->count();
            $previous = Enquiry::whereBetween('created_at', [
                $start->copy()->subDays($end->diffInDays($start)),
                $start->copy()
            ])->count();

            $change = $previous > 0
                ? round((($current - $previous) / $previous) * 100)
                : ($current > 0 ? 100 : 0);

            return ['count' => $current, 'change' => $change];
        };

        return response()->json([
            'last_24_hours' => $getStats($now->copy()->subDay(), $now),
            'last_7_days'   => $getStats($now->copy()->subDays(7), $now),
            'last_30_days'  => $getStats($now->copy()->subDays(30), $now),
        ]);
    }
}
