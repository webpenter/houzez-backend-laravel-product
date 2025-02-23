<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyRequest;
use App\Http\Resources\Property\UserPropertyResource;
use App\Http\Resources\Property\EditPropertyResource;
use App\Models\Property;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class PropertyController extends Controller
{
    protected $propertyRepository;

    /**
     * Inject the PropertyRepository into the controller.
     *
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * ## Get User Properties
     *
     * Handles API requests to fetch user properties with optional search and sorting.
     *
     * @param Request $request The incoming HTTP request containing filters.
     * @return JsonResponse JSON response with properties list.
     */
    public function getUserProperties(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $sortBy = $request->input('sortBy', 'default');
        $propertyStatus = $request->input('propertyStatus');

        $properties = $this->propertyRepository->getUserProperties(Auth::id(), $search, $sortBy, $propertyStatus);

        return new JsonResponse([
            'status' => 'success',
            'properties' => UserPropertyResource::collection($properties),
        ], 200);
    }

    /**
     * ## Create or Update Property
     *
     * - If an ID is provided, it updates the existing property.
     * - If no ID is provided, it creates a new property.
     * - Ensures the authenticated user is the owner before updating.
     * - Returns a JSON response with success or error messages.
     *
     * @param PropertyRequest $request
     * @param int|null $id
     * @return JsonResponse
     */
    public function createOrUpdate(PropertyRequest $request, $id = null): JsonResponse
    {
        try {
            $data = $request->validated();
            $property = $this->propertyRepository->createOrUpdate($data, $id);

            return new JsonResponse([
                'message' => $id ? 'Property updated successfully.' : 'Property created successfully.',
                'property' => $property,
            ], $id ? 200 : 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    /**
     * ## Edit Property
     *
     * Fetches a specific property for editing.
     * Ensures that the authenticated user is the owner of the property.
     *
     * @param int $propertyId
     * @return JsonResponse
     */
    public function edit(int $propertyId): JsonResponse
    {
        try {
            $property = $this->propertyRepository->getPropertyForEdit($propertyId);

            return new JsonResponse([
                'status' => 'success',
                'property' => new EditPropertyResource($property),
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    /**
     * ## Deleting Property
     *
     * Handles the request to delete a property.
     *
     * @param int $id The ID of the property to delete.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->propertyRepository->deleteProperty($id);
            return new JsonResponse([
                'message' => 'Property deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    /**
     * ## Duplicating Property
     *
     * Handles the request to duplicate a property.
     *
     * @param int $id The ID of the property to duplicate.
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicate($id): JsonResponse
    {
        try {
            $newProperty = $this->propertyRepository->duplicateProperty($id);

            return new JsonResponse([
                'message' => 'Property duplicated successfully',
                'property' => $newProperty
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

}
