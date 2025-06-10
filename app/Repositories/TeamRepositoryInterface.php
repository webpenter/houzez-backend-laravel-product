<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;
interface TeamRepositoryInterface
{
    /**
     * Get all teams.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find a team by ID.
     *
     * @param int $id
     * @return Team
     */
    public function find(int $id): Team;

    /**
     * Create a new team.
     *
     * @param array $data
     * @return Team
     */
    public function create(array $data): Team;

    /**
     * Update a team.
     *
     * @param int $id
     * @param array $data
     * @return Team
     */
    public function update(int $id, array $data): Team;

    /**
     * Delete a team.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get app teams.
     *
     * @return Collection
     */
    public function app(): Collection;
}
