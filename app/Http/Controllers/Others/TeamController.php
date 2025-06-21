<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Resources\Team\AppTeamResource;
use App\Http\Resources\Team\AppTeamResourceDemo01;
use App\Traits\ResponseTrait;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Http\Resources\Team\TeamResource;
use App\Services\TeamService;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected TeamService $teamService,
        protected TeamRepositoryInterface $teamRepo
    ) {}

    /**
     * Get all teams.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $teams = $this->teamRepo->all();
        return $this->successResponse(TeamResource::collection($teams));
    }

    /**
     * Store a new team.
     *
     * @param StoreTeamRequest $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        $team = $this->teamService->store($request->validated());
        return $this->successResponse(new TeamResource($team), 'Team created successfully', 201);
    }

    /**
     * Show a team by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $team = $this->teamRepo->find($id);
        return $this->successResponse(new TeamResource($team));
    }

    /**
     * Update a team.
     *
     * @param UpdateTeamRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, int $id): JsonResponse
    {
        $team = $this->teamService->update($id, $request->validated());
        return $this->successResponse(new TeamResource($team), 'Team updated successfully');
    }

    /**
     * Delete a team.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->teamRepo->delete($id);
        return $this->successResponse(null, 'Team deleted successfully');
    }

    /**
     * Get all teams.
     *
     * @return JsonResponse
     */
    public function getAppTeams(): JsonResponse
    {
        $teams = $this->teamRepo->app();
        return $this->successResponse(AppTeamResource::collection($teams));
    }

    /**
     * Get latest 3 team members.
     *
     * @return JsonResponse
     */
    public function getAppTeamsDemo01(): JsonResponse
    {
        $teams = $this->teamRepo->app()->sortByDesc('created_at')->take(3);
        return $this->successResponse(AppTeamResourceDemo01::collection($teams));
    }
}
