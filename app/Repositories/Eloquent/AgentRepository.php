<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\AgentReview;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AgentRepository implements AgentRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('profile','agencies')
            ->where('role', 'agent')
             ->withAvg('agentReviews', 'rating')
            ->get();
    }

    
    /**
     * Get all reviews for a specific agent.
     */
    public function getReviewsByAgent(int $agentId)
    {
        return AgentReview::where('agent_id', $agentId)->latest()->get();
    }

    /**
     * Create a new review.
     */
    public function createReview(array $data): AgentReview
    {
        return AgentReview::create([
            'agent_id' => $data['agent_id'],
            'user_id'   => auth()->id(),
            'title'     => $data['title'],
            'rating'    => $data['rating'],
            'comment'   => $data['comment'],
        ]);
    }

    /**
     * Find a user by username and include property statistics.
     *
     * @param string $username The username to search for
     *
     * @return User|null Returns the User model with appended statistical data or null if not found
     */
    public function findByUsernameWithStats(string $username): ?User
    {
        $user = User::where('username', $username)->first();

        if (!$user) return null;

        $typeCounts = Property::where('user_id', $user->id)
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->limit(4)
            ->get();

        $total = Property::where('user_id', $user->id)->count();

        $topTypes = $typeCounts->map(function ($item) use ($total) {
            return [
                'type' => $item->type,
                'count' => $item->count,
                'percentage' => $total > 0 ? round(($item->count / $total) * 100) : 0,
            ];
        });

         $statusSummary = $user->properties()
        ->select('status', DB::raw('count(*) as total'))
        ->whereIn('status', ['sale', 'rent'])
        ->groupBy('status')
        ->get()
        ->map(function ($item) use ($total) {
            return [
                'status' => $item->status,
                'percentage' => $total > 0 ? round(($item->total / $total) * 100) : 0,
            ];
        });

        $topCities = $user->properties()
        ->select('city', DB::raw('count(*) as total'))
        ->whereNotNull('city')
        ->groupBy('city')
        ->orderByDesc('total')
        ->limit(4)
        ->get()
        ->map(function ($item) use ($total) {
            return [
                'city' => $item->city,
                'percentage' => $total > 0 ? round(($item->total / $total) * 100) : 0,
            ];
        });

        $user->top_types = $topTypes;
        $user->status_summary = $statusSummary;
        $user->top_cities = $topCities;

        return $user;
    }


}
