<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bedroom\BedroomRequest;
use App\Models\Bedroom;
use App\Repositories\BedroomRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BedroomController extends Controller
{
    protected $bedroomRepository;

    public function __construct(BedroomRepositoryInterface $bedroomRepository)
    {
        $this->bedroomRepository = $bedroomRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->bedroomRepository->getAll(), 200);
    }

    public function store(BedroomRequest $request): JsonResponse
    {
        $bedroom = $this->bedroomRepository->create($request->validated());
        return response()->json($bedroom, 201);
    }

    public function show(Bedroom $bedroom): JsonResponse
    {
        return response()->json($this->bedroomRepository->findById($bedroom->id), 200);
    }

    public function update(BedroomRequest $request, Bedroom $bedroom): JsonResponse
    {
        $updatedBedroom = $this->bedroomRepository->update($bedroom, $request->validated());
        return response()->json($updatedBedroom, 200);
    }

    public function destroy(Bedroom $bedroom): JsonResponse
    {
        $this->bedroomRepository->delete($bedroom);
        return response()->json(['message' => 'Bedroom deleted successfully'], 200);
    }
}