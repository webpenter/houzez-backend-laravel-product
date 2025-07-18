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
        return User::where('role', 'agent')->get();
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('role', 'agent')
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
    public function create(array $data): AgentReview
    {
        return AgentReview::create($data);
    }

}
