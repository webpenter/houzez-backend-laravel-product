<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Agent\AgentsResource;
use App\Http\Resources\Agent\AgentWithPropertiesResource;

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

        $agent = $agent ? $agent->load(['profile', 'properties','agencies', 'agentReviews']) : null;

        return $agent
            ? response()->json(['success' => true, 'data' => new AgentWithPropertiesResource($agent)])
            : response()->json(['success' => false, 'message' => 'Agent not found'], 404);
    }

}
