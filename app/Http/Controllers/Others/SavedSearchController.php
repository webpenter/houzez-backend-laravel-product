<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavedSearch\SavedSearchRequest;
use App\Repositories\SavedSearchRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavedSearchController extends Controller
{
    protected SavedSearchRepositoryInterface $savedSearchRepository;

    public function __construct(SavedSearchRepositoryInterface $savedSearchRepository)
    {
        $this->savedSearchRepository = $savedSearchRepository;
    }

    public function getUserSearches(): JsonResponse
    {
        $searches = $this->savedSearchRepository->getUserSearches();

        return response()->json([
            'success'  => true,
            'count'    => $searches->count(),
            'searches' => $searches,
        ]);
    }

    public function storeOrRemoveSearch(SavedSearchRequest $request): JsonResponse
    {

        $result = $this->savedSearchRepository->storeOrRemoveSearch($request->validated());

        return response()->json([
            'success' => true,
            ...$result,
        ], $result['action'] === 'saved' ? 201 : 200);
    }

    public function isSearchSaved(SavedSearchRequest $request): JsonResponse
    {
        $exists = $this->savedSearchRepository->isSearchSaved($request->validated());

        return response()->json([
            'success' => true,
            'isSaved' => $exists,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->savedSearchRepository->deleteSearch($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Search not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Search deleted successfully.',
        ]);
    }
}
