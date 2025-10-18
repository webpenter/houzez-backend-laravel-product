<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\AgencyReview;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use App\Repositories\AgencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AgencyRepository implements AgencyRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('profile')
            ->where('role', 'agency')
             ->withAvg('agencyReviews', 'rating')
            ->get();
    }


    /**
     * Get all reviews for a specific agency.
     */
    public function getReviewsByAgency(int $agencyId)
    {
        return AgencyReview::where('agency_id', $agencyId)->latest()->get();
    }

    /**
     * Create a new review.
     */
    public function createReview(array $data): AgencyReview
    {
        return AgencyReview::create([
            'agency_id' => $data['agency_id'],
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

        // If user not found, return null
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


    public function getAllProperties(User $user): Collection
    {
        // Ensure user is an agency
        if ($user->role !== 'agency') {
            throw new \Exception('User is not an agency');
        }

        // Fetch agent IDs assigned to this agency
        $agentIds = DB::table('agency_agent')
            ->where('agency_id', $user->id)
            ->pluck('agent_id')
            ->toArray();

        // Merge agency ID + agent IDs
        $userIds = array_merge([$user->id], $agentIds);

        // Fetch all properties related to this agency and its agents
        return Property::with(['user.profile', 'assignedAgent.profile'])
            ->whereIn('user_id', $userIds)
            ->get();
    }


    /**
     * Search agencies by name and address.
     *
     * Eager loads related `profile` and `agencies` data, and calculates
     * average rating from `agentReviews`. Filters results by agency name
     * and address if provided.
     *
     * @param string|null $name     Optional agency owner full name.
     * @param string|null $address  Optional agency address.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $name, ?string $address): Collection
    {
        return User::with('profile', 'agencies')
            ->where('role', 'agency')
            ->withAvg('agentReviews', 'rating')
            ->when($name, function ($query) use ($name) {
                $query->whereHas('profile', function ($q) use ($name) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$name}%"]);
                });
            })
            ->when($address, function ($query) use ($address) {
                $query->whereHas('profile', function ($q) use ($address) {
                    $q->where('address', 'LIKE', "%{$address}%");
                });
            })
            ->get();
    }
}
