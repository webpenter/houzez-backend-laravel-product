<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Agent\AgentsResource;
use App\Http\Resources\Agent\AgentWithPropertiesResource;
use App\Http\Resources\Agent\AgentReviewsResource;
use App\Http\Requests\Others\StoreAgentReviewRequest;

use Illuminate\Http\Request;
use App\Models\User;

class AgentController extends Controller
{
    protected $agentRepository;

    public function __construct(AgentRepositoryInterface $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    /**
     * ## Get all agents
     */
    public function index(): JsonResponse
    {
        $agents = $this->agentRepository->all();

        return new JsonResponse([
            'success' => true,
            'data' => AgentsResource::collection($agents),
        ]);
    }

    /**
     * ## Get agent by username
     */
    public function show(string $username): JsonResponse
    {
        $agent = $this->agentRepository->findByUsernameWithStats($username);

        return new JsonResponse(
            $agent
                ? ['success' => true, 'data' => new AgentWithPropertiesResource($agent)]
                : ['success' => false, 'message' => 'Agent not found'],
            $agent ? 200 : 404
        );
    }

    /**
     * Fetch reviews for a specific agent.
     * @return JsonResponse
     */
    public function showReviews(int $agentId): JsonResponse
    {
        $reviews = $this->agentRepository->getReviewsByAgent($agentId);
        return new JsonResponse([
            'success' => true,
            'data' => AgentReviewsResource::collection($reviews),
        ], 200);
    }

     /**
     * Store a new review.
     * @return JsonResponse
     */
    public function store(StoreAgentReviewRequest $request): JsonResponse
    {
        $review = $this->agentRepository->createReview($request->validated());

        return new JsonResponse([
            'success' => true,
            'data' => new AgentReviewsResource($review),
        ], 201);
    }

    public function searchAgent(Request $request)
    {
        // Validate search parameters
        $validated = $request->validate([
            'name' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $name = $request->name;
        $address = $request->address;

        // Eager load profiles and fetch only agents
        $agents = User::with('profile')
            ->where('role', 'agent')
            ->when($name, function ($query) use ($name) {
                $query->whereHas('profile', function ($q) use ($name) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$name}%"]);
                });
            })
            ->when($address, function ($query) use ($address) {
                $query->whereHas('profile', function ($q) use ($address) {
                    $q->where('address', 'LIKE', "%{$address}%");
                });
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agents
        ]);
    }   
}
