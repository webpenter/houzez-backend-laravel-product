<?php

namespace App\Repositories\Eloquent;

use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SavedSearchRepositoryInterface;

class SavedSearchRepository implements SavedSearchRepositoryInterface
{
    /**
     * Get all saved searches for the authenticated user.
     */
    public function getUserSearches()
    {
        return SavedSearch::where('user_id', Auth::id())
            ->select('id', 'parameters')
            ->latest()
            ->get();
    }

    /**
     * Store or remove a saved search for the authenticated user.
     */
    public function storeOrRemoveSearch(array $data): array
    {
        $userId = Auth::id();

        $existing = SavedSearch::where('user_id', $userId)
            ->where('parameters', $data['parameters'])
            ->first();

        if ($existing) {
            $existing->delete();
            return [
                'action'  => 'removed',
                'message' => 'Search removed successfully.',
            ];
        }

        $search = SavedSearch::create([
            'user_id'    => $userId,
            'parameters' => $data['parameters'],
        ]);

        return [
            'action'  => 'saved',
            'message' => 'Search saved successfully.',
            'data'    => $search,
        ];
    }

    /**
     * Check if a saved search exists.
     */
    public function isSearchSaved(array $data): bool
    {
        return SavedSearch::where('user_id', Auth::id())
            ->where('parameters', $data['parameters'])
            ->exists();
    }

    /**
     * Delete a saved search by ID.
     */
    public function deleteSearch(int $id): bool
    {
        $search = SavedSearch::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$search) {
            return false;
        }

        return (bool) $search->delete();
    }
}
