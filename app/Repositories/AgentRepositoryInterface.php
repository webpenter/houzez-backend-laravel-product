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
     * Get all reviews for a specific agent.
     *
     * This method retrieves all reviews associated with the given agent ID.
     * It is useful for displaying feedback and ratings for an agent.
     *
     * @param int $agentId  The unique ID of the agent.
     *
     * @return \Illuminate\Database\Eloquent\Collection  A collection of reviews for the specified agent.
     */
    public function getReviewsByAgent(int $agentId);


    /**
     * Create a new review for an agent.
     *
     * This method stores a new review record for the specified agent, 
     * including rating and review content, and returns the created review instance.
     *
     * @param array $data  The validated review data (e.g., agent_id, user_id, rating, comment).
     *
     * @return \App\Models\AgentReview  The newly created agent review instance.
     */
    public function createReview(array $data): AgentReview;


    /**
     * Find a user by username and include property statistics.
     *
     * @param string $username The username to search for
     *
     * @return User|null Returns the User model with appended statistical data or null if not found
     */
    public function findByUsernameWithStats(string $username): ?User;

    
    /**
     * Search for agents by optional name and address.
     *
     * This method retrieves a collection of agents filtered by the provided
     * name and/or address. It also eager loads related `profile` and `agencies`
     * data, and calculates the average rating from `agentReviews`.
     *
     * @param string|null $name     Optional agent full name (first + last).
     * @param string|null $address  Optional agent address or city.
     *
     * @return \Illuminate\Database\Eloquent\Collection  A collection of agents matching the criteria.
     */
    public function search(?string $name, ?string $address): Collection;
}
