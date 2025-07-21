<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\AgentReview;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AgentRepository implements AgentRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('profile')
            ->where('role', 'agent')
             ->withAvg('agentReviews', 'rating') 
            ->get();
    }

    public function findByUsername(string $username): ?User
    {
        return User::with(['profile', 'properties', 'agencies'])
            ->where('role', 'agent')
            ->where('username', $username)
            ->first();
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
        'agent_id' => $request->agent_id,
        'user_id' => auth()->id(),
        'title' => $request->title,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);
}

}
