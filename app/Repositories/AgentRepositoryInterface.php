<?php

namespace App\Repositories;

use App\Models\User;
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
}
