<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\AgentReview;
use Illuminate\Database\Eloquent\Collection;

interface AgencyRepositoryInterface
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

    public function getReviewsByAgency(int $agencyId);

    // public function createReview(array $data): AgentReview;

    /**
     * Find a user by username and include property statistics.
     *
     * @param string $username The username to search for
     *
     * @return User|null Returns the User model with appended statistical data or null if not found
     */
    public function findByUsernameWithStats(string $username): ?User;


}
