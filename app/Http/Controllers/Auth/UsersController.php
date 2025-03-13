<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UsersResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Retrieve all users from the database.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing all users.
     */
    public function getAllUsers(): JsonResponse
    {
        $users = User::all();
        return new JsonResponse(UsersResource::collection($users));
    }

    /**
     * Delete a user along with their profile and profile picture.
     *
     * @param int $userId The ID of the user to be deleted.
     * @return JsonResponse JSON response indicating success or failure.
     */
    public function deleteUser($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $profile = $user->profile;

        if ($profile) {
            if (!empty($profile->profile_picture)) {
                $picturePath = public_path('profile-picture/' . basename($profile->profile_picture));
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
            }

            $profile->delete();
        }

        $user->delete();

        return new JsonResponse(['message' => 'User and profile deleted successfully'], 200);
    }

}
