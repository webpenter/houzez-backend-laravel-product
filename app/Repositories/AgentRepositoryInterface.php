<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\AgentReview;
use Illuminate\Database\Eloquent\Collection;

interface AgentRepositoryInterface
{
    /**
     * ## Get all users with 'agent' role
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * ## Find agent by username
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User;

    public function getReviewsByAgent(int $agentId);

    public function create(array $data): AgentReview;


}
