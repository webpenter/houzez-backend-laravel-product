<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UsersRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Delete a user by ID.
     *
     * @param int $userId
     * @return array
     */
    public function deleteUser(int $userId): array;

    /**
     * Update user role.
     *
     * @param int $userId
     * @param string $role
     * @return array
     */
    public function updateUserRole(int $userId, string $role): array;

    /**
     * Get All Agents.
     *
     *  @return Collection
     */
    public function getAllAgents(): Collection;

     /**
     * Get All Agencies.
     *
     *  @return Collection
     */
    public function getAgencyUsers(): Collection;

    /**
     * Create a new user.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
}
