<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UsersResource;
use App\Repositories\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    private UsersRepositoryInterface $userRepository;

    /**
     * Constructor to inject the user repository.
     *
     * @param UsersRepositoryInterface $userRepository
     */
    public function __construct(UsersRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve all users from the database.
     *
     * @return JsonResponse A JSON response containing all users.
     */
    public function getAllUsers(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return new JsonResponse(UsersResource::collection($users));
    }

    /**
     * Delete a user along with their profile and profile picture.
     *
     * @param int $userId The ID of the user to be deleted.
     * @return JsonResponse JSON response indicating success or failure.
     */
    public function deleteUser(int $userId): JsonResponse
    {
        $result = $this->userRepository->deleteUser($userId);
        return new JsonResponse($result['message'], $result['status']);
    }

    /**
     * Update the role of a user and set the is_admin field if the role is 'admin'.
     *
     * @param int $userId The ID of the user to update.
     * @param string $role The new role for the user.
     * @return JsonResponse JSON response indicating success or failure.
     */
    public function updateUserRole(int $userId, string $role): JsonResponse
    {
        $result = $this->userRepository->updateUserRole($userId, $role);
        return new JsonResponse($result['message'], $result['status']);
    }
}
