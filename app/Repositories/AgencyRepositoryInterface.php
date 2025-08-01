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
    

    /**
     * Get all reviews for a specific agency.
     *
     * This method retrieves all reviews associated with the given agency ID.
     * It can be used to display feedback and ratings for an agency.
     *
     * @param int $agencyId  The unique ID of the agency.
     *
     * @return \Illuminate\Database\Eloquent\Collection  A collection of reviews for the specified agency.
     */
    public function getReviewsByAgency(int $agencyId);

    
    /**
     * Create a new review for an agency.
     *
     * This method stores a new review record for the specified agency, 
     * including rating and review content, and returns the created review instance.
     *
     * @param array $data  The validated review data (e.g., agency_id, user_id, rating, comment).
     *
     * @return \App\Models\AgencyReview  The newly created agency review instance.
     */
    public function createReview(array $data): AgencyReview;


    /**
     * Get all properties belonging to an agency and its assigned agents.
     *
     * @param \App\Models\User $user  The agency user instance.
     *
     * @return \Illuminate\Support\Collection  A collection of properties for the agency and its agents.
     */
    public function getAllProperties(User $user): Collection;


    /**
     * Search for agencies by optional name and address.
     *
     * @param string|null $name     Optional agency owner full name (first + last).
     * @param string|null $address  Optional agency address or city.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $name, ?string $address): Collection;
}
