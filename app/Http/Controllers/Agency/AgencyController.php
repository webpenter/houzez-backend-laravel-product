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

    public function getAllAgencyProperties(User $user)
    {

    // Ensure this user is an agency
    if ($user->role !== 'agency') {
        return response()->json(['message' => 'User is not an agency'], 403);
    }

    // Fetch all agents assigned to the agency
    $agentIds = \DB::table('agency_agent')
        ->where('agency_id', $user->id)
        ->pluck('agent_id')
        ->toArray();

    // Combine agency + agent IDs
    $userIds = array_merge([$user->id], $agentIds);

    // Get all related properties with eager loading
    $properties = Property::with(['user.profile', 'assignedAgent.profile'])
        ->whereIn('user_id', $userIds)
        ->get();

    return new JsonResponse([
            'success' => true,
            'agency' => $user->username,
            'total_properties' => $properties->count(),
            'data' => AppPropertyCardDemo01Resource::collection($properties),
        ], 200);
    }

}
