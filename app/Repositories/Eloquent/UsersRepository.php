<?php

namespace App\Repositories\Eloquent;

use App\Repositories\UsersRepositoryInterface;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class UsersRepository implements UsersRepositoryInterface
{

    protected $userModel;

    /**
     * UsersRepository constructor.
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * Delete a user by ID.
     *
     * @param int $userId
     * @return array
     */
    public function deleteUser(int $userId): array
    {
        $user = User::find($userId);

        if (!$user) {
            return ['message' => 'User not found', 'status' => 404];
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

        return ['message' => 'User and profile deleted successfully', 'status' => 200];
    }

    /**
     * Update user role.
     *
     * @param int $userId
     * @param string $role
     * @return array
     */
    public function updateUserRole(int $userId, string $role): array
    {
        $user = User::find($userId);

        if (!$user) {
            return ['message' => 'User not found', 'status' => 404];
        }

        $user->role = $role;
        $user->is_admin = ($role === 'administrator');
        $user->save();

        return ['message' => 'User role updated successfully', 'status' => 200];
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function getAllAgents(): Collection
    {
        return User::where('role', 'agent')
            ->withCount('properties')
            ->get();
    }

    /**
     * Get all agencies
     *
     * @return Collection
     */
    public function getAgencyUsers(): Collection
    {
        return User::where('role', 'agency')
            ->withCount('properties')
            ->get();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return Model
     * @throws InvalidArgumentException
     */
    public function create(array $data): Model
    {
        if (!isset($data['username'], $data['email'], $data['password'])) {
            throw new InvalidArgumentException('Required user data (username, email, password) is missing.');
        }

        return $this->userModel->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
