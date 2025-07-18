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

        $agents = $agents ? $agents->load(['profile']) : null;

        return response()->json([
            'success' => true,
            'data' => AgentsResource::collection($agents)
        ]);
    }

    /**
     * ## Get agent by username
     */
    public function show(string $username): JsonResponse
    {
        $agent = $this->agentRepository->findByUsername($username);

        $agent = $agent ? $agent->load(['profile', 'properties','agencies']) : null;

        return $agent
            ? response()->json(['success' => true, 'data' => new AgentWithPropertiesResource($agent)])
            : response()->json(['success' => false, 'message' => 'Agent not found'], 404);
    }

    /**
     * Fetch reviews for a specific agent.
     * @return JsonResponse
     */
    public function showReviews(int $agentId): JsonResponse
    {
        $reviews = $this->agentRepository->getReviewsByAgent($agentId);
        return response()->json(AgentReviewsResource::collection($reviews));
    }

     /**
     * Store a new review.
     * @return JsonResponse
     */
    public function store(StoreAgentReviewRequest $request): JsonResponse
    {
        $review = $this->agentRepository->create([
            'agent_id' => $request->agent_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(new AgentReviewsResource($review), 201);
    }

}
