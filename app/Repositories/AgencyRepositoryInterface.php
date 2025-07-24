<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\AgencyReview;
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
     * Find a user by username and include property statistics.
     *
     * @param string $username The username to search for
     *
     * @return User|null Returns the User model with appended statistical data or null if not found
     */
    public function findByUsernameWithStats(string $username): ?User;


    

    public function getReviewsByAgency(int $agencyId);

    public function createReview(array $data): AgencyReview;

}
