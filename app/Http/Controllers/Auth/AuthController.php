<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Repositories\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class AuthController extends Controller
{
    protected $usersRepository;

    /**
     * AuthController constructor.
     *
     * @param UsersRepositoryInterface $usersRepository
     */
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Register a new user and return their details along with an authentication token.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->usersRepository->create($request->validated());
            $token = $user->generateToken();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'admin' => $user->isAdmin(),
                    'isSubscribed' => $user->canCreateProperty(),
                ],
            ], 201);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Authenticate a user and return their details along with an authentication token.
     *
     * @param \App\Http\Requests\LoginRequest $request The HTTP request containing login credentials (email and password).
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message, the authenticated user data, and a Sanctum authentication token,
     *                                        or an error message if the credentials are invalid.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return new JsonResponse([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $token = $user->generateToken();
        $admin = $user->isAdmin();
        $isSubscribed = $user->canCreateProperty();

        return new JsonResponse([
            'message' => 'Login successful',
            'user' => new UserResource($user),
            'token' => $token,
            'admin' => $admin,
            'isSubscribed' => $isSubscribed,
        ],200);
    }

    /**
     * Log out the authenticated user by revoking all their active tokens.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response confirming the logout action.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        return new JsonResponse([
            'message' => 'Logged out successfully',
            'status' => 200
        ]);
    }

    /**
     * Retrieve the authenticated user's details.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     *
     * @return \App\Http\Resources\UserResource A resource representing the authenticated user's details.
     */
    public function getUser(Request $request): JsonResponse
    {
        $user = Auth::user();
        $admin = $user->isAdmin();
        $isSubscribed = $user->canCreateProperty();

        return new JsonResponse([
            'status' => 200,
            'user' => new UserResource($user),
            'admin' => $admin,
            'isSubscribed' => $isSubscribed,
        ]);
    }

    /**
     * Change the authenticated user's password.
     *
     * @param \App\Http\Requests\ChangePasswordRequest $request The HTTP request containing the current and new password.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message if the password is updated, or an error message if the current password is incorrect.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return new JsonResponse([
                'message' => 'Current password is incorrect'
            ], 403);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return new JsonResponse([
            'message' => 'Password updated successfully'
        ]);
    }

    /**
     * Delete the authenticated user's account and revoke all associated tokens.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response confirming the account deletion.
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        $user = Auth::user();

        $profile = $user->profile;
        if ($profile) {
            $profile->delete();
        }

        $user->tokens()->delete();
        $user->delete();

        return new JsonResponse([
            'message' => 'Account deleted successfully'
        ]);
    }
}
