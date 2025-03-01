<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bedroom\BedroomRequest;
use App\Models\Bedroom;
use App\Repositories\BedroomRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class BedroomController
 *
 * Handles all operations related to bedrooms, using repository pattern for database interactions.
 */
class BedroomController extends Controller
{
    protected $bedroomRepository;

    /**
     * Inject BedroomRepositoryInterface into the controller.
     *
     * @param BedroomRepositoryInterface $bedroomRepository
     */
    public function __construct(BedroomRepositoryInterface $bedroomRepository)
    {
        $this->bedroomRepository = $bedroomRepository;
    }

    /**
     * Get a list of all bedrooms.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->bedroomRepository->getAll(), 200);
    }

    /**
     * Store a new bedroom.
     *
     * @param BedroomRequest $request
     * @return JsonResponse
     */
    public function store(BedroomRequest $request): JsonResponse
    {
        // Validate request and create a new bedroom
        $bedroom = $this->bedroomRepository->create($request->validated());
        return response()->json($bedroom, 201);
    }

    /**
     * Show details of a specific bedroom.
     *
     * @param Bedroom $bedroom
     * @return JsonResponse
     */
    public function show(Bedroom $bedroom): JsonResponse
    {
        return response()->json($this->bedroomRepository->findById($bedroom->id), 200);
    }

    /**
     * Update a specific bedroom's details.
     *
     * @param BedroomRequest $request
     * @param Bedroom $bedroom
     * @return JsonResponse
     */
    public function update(BedroomRequest $request, Bedroom $bedroom): JsonResponse
    {
        // Validate request and update the bedroom
        $updatedBedroom = $this->bedroomRepository->update($bedroom, $request->validated());
        return response()->json($updatedBedroom, 200);
    }

    /**
     * Delete a specific bedroom.
     *
     * @param Bedroom $bedroom
     * @return JsonResponse
     */
    public function destroy(Bedroom $bedroom): JsonResponse
    {
        // Delete the bedroom record
        $this->bedroomRepository->delete($bedroom);
        return response()->json(['message' => 'Bedroom deleted successfully'], 200);
    }
}