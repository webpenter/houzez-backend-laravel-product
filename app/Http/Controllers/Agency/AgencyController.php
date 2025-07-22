<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Agency\AgenciesResource;
// use App\Http\Resources\Agencies\AgentWithPropertiesResource;
// use App\Http\Resources\Agencies\AgentReviewsResource;
// use App\Http\Requests\Others\StoreAgentReviewRequest;

use Illuminate\Http\Request;
use App\Models\User;

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
                ? ['success' => true, 'data' => new AgentWithPropertiesResource($agency)]
                : ['success' => false, 'message' => 'Agent not found'],
            $agency ? 200 : 404
        );
    }

    /**
     * Fetch reviews for a specific agent.
     * @return JsonResponse
     */
    // public function showReviews(int $agentId): JsonResponse
    // {
    //     $reviews = $this->agentRepository->getReviewsByAgent($agentId);
    //     return new JsonResponse([
    //         'success' => true,
    //         'data' => AgentReviewsResource::collection($reviews),
    //     ], 200);
    // }

     /**
     * Store a new review.
     * @return JsonResponse
     */
    // public function store(StoreAgentReviewRequest $request): JsonResponse
    // {
    //     $review = $this->agentRepository->createReview($request);

    //     return new JsonResponse([
    //         'success' => true,
    //         'data' => new AgentReviewsResource($review),
    //     ], 201);
    // }

}
