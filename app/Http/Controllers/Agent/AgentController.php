<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Http\JsonResponse;

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

        return response()->json([
            'success' => true,
            'data' => $agents
        ]);
    }

    /**
     * ## Get agent by username
     */
    public function show(string $username): JsonResponse
    {
        $agent = $this->agentRepository->findByUsername($username);

        $agent = $agent ? $agent->load(['profile']) : null;
        return $agent
            ? response()->json(['success' => true, 'data' => $agent])
            : response()->json(['success' => false, 'message' => 'Agent not found'], 404);
    }
}
