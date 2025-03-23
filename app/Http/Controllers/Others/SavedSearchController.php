<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\SavedSearch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedSearchController extends Controller
{
    /**
     * Get all saved searches for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getUserSearches(): JsonResponse
    {
        $searches = SavedSearch::whereUserId(Auth::id())->get(['id', 'parameters']);
        return response()->json([ 'searches' => $searches]);
    }

    /**
     * Store or remove a saved search for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeOrRemoveSearch(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'parameters' => 'required|string',
        ]);

        $userId = Auth::id();
        $existingSearch = SavedSearch::where('user_id', $userId)
            ->where('parameters', $validated['parameters'])
            ->first();

        if ($existingSearch) {
            $existingSearch->delete();
            return response()->json(['success' => true, 'message' => 'Search removed.'], 204);
        } else {
            $search = SavedSearch::create([
                'user_id' => $userId,
                'parameters' => $validated['parameters'],
            ]);
            return response()->json(['success' => true, 'data' => $search], 201);
        }
    }

    /**
     * Check if a saved search exists for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function isSearchSaved(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'parameters' => 'required|string',
        ]);

        $userId = Auth::id();
        $exists = SavedSearch::where('user_id', $userId)
            ->where('parameters', $validated['parameters'])
            ->exists();

        return response()->json(['success' => true, 'isSaved' => $exists]);
    }

    /**
     * Delete a saved search by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $search = SavedSearch::whereId($id)->whereUserId(Auth::id())->first();

        if (!$search) {
            return response()->json([ 'success' => false, 'message' => 'Search not found' ], 404);
        }

        $search->delete();
        return response()->json([ 'success' => true, 'message' => 'Search deleted successfully' ]);
    }
}
