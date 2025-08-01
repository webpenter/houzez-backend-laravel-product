<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Agency\AgenciesResource;
use App\Http\Resources\Agency\AgencyWithPropertiesResource;
use App\Http\Resources\Demos\Demo01\Property\AppPropertyCardDemo01Resource;
use App\Http\Resources\Agency\AgencyReviewsResource;
use App\Http\Requests\Others\StoreAgencyReviewRequest;
use App\Http\Requests\Others\SearchRequest;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class AgencyController extends Controller
{
    protected $agencyRepository;

    public function __construct(AgencyRepositoryInterface $agencyRepository)
    {
        $this->agencyRepository = $agencyRepository;
    }


    /**
     * ## Get all agents
     */
    public function index(): JsonResponse
    {
        $agencies = $this->agencyRepository->all();

        return new JsonResponse([
            'success' => true,
            'data' => AgenciesResource::collection($agencies),
        ]);
    }


    /**
     * ## Get agent by username
     */
    public function show(string $username): JsonResponse
    {
        $agency = $this->agencyRepository->findByUsernameWithStats($username);

        return new JsonResponse(
            $agency
                ? ['success' => true, 'data' => new AgencyWithPropertiesResource($agency)]
                : ['success' => false, 'message' => 'Agency not found'],
            $agency ? 200 : 404
        );
    }


    /**
     * Fetch reviews for a specific agent.
     * @return JsonResponse
     */
    public function showReviews(int $agencyId): JsonResponse
    {
        $reviews = $this->agencyRepository->getReviewsByAgency($agencyId);
        return new JsonResponse([
            'success' => true,
            'data' => AgencyReviewsResource::collection($reviews),
        ], 200);
    }


     /**
     * Store a new review.
     * @return JsonResponse
     */
    public function store(StoreAgencyReviewRequest $request): JsonResponse
    {
        $review = $this->agencyRepository->createReview($request->validated());

        return new JsonResponse([
            'success' => true,
            'data' => new AgencyReviewsResource($review),
        ], 201);
    }

    
    /**
     * Get all properties for an agency (including its agents).
     *
     * This method validates that the user is an agency, fetches its assigned agents,
     * retrieves all properties listed by the agency or its agents, and returns the result.
     *
     * @param \App\Models\User $user  The agency user (via route model binding).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAgencyProperties(User $user): JsonResponse
    {
        try {
            // Fetch properties from repository
            $properties = $this->agencyRepository->getAllProperties($user);

            return new JsonResponse([
                'success' => true,
                'agency' => $user->username,
                'total_properties' => $properties->count(),
                'data' => AppPropertyCardDemo01Resource::collection($properties),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }
    

   /**
     * Search agencies by name and address.
     *
     */
    public function searchAgency(SearchRequest $request): JsonResponse
    {
        // Call repository method to fetch filtered agencies
        $agencies = $this->agencyRepository->search(
            $request->name,
            $request->address
        );

        // Return response with agencies resource collection
        return new JsonResponse([
            'success' => true,
            'data' => AgenciesResource::collection($agencies),
        ]);
    }

}