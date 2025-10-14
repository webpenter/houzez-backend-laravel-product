<?php

namespace App\Repositories;

interface SavedSearchRepositoryInterface
{
    /**
     * Get all saved searches for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserSearches();

    /**
     * Store or remove a saved search for the authenticated user.
     *
     * @param array $data
     * @return array
     */
    public function storeOrRemoveSearch(array $data): array;

    /**
     * Check if a saved search exists for the authenticated user.
     *
     * @param array $data
     * @return bool
     */
    public function isSearchSaved(array $data): bool;

    /**
     * Delete a saved search by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSearch(int $id): bool;
}
