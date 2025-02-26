<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserProfileResource;
use App\Http\Resources\Auth\UserSocialMediaResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Retrieve the authenticated user's profile picture URL.
     *
     * @return string|null The URL of the user's profile picture, or null if not set.
     */
    public function getProfilePicture(): ?string
    {
        $user = Auth::user();
        $profile = $user->profile;

        return $profile->profile_picture ?? null;
    }


    /**
     * Update the authenticated user's profile picture.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the profile picture file.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message and the URL of the updated profile picture.
     */
    public function updateProfilePicture(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([]);
        }

        if (!empty($profile->profile_picture)) {
            $oldPicturePath = public_path('profile-picture/' . basename($profile->profile_picture));
            if (file_exists($oldPicturePath)) {
                unlink($oldPicturePath);
            }
        }

        $file = $request->file('profile_picture');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile-picture'), $fileName);

        $fullPath = url('profile-picture/' . $fileName);
        $profile->profile_picture = $fullPath;
        $profile->save();

        return new JsonResponse([
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => $fullPath,
        ], 200);
    }

    /**
     * Get the authenticated user's profile information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileInformation(): JsonResponse
    {
        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['user_id' => $user->id]);
        }

        return new JsonResponse([
            'message' => 'Profile information fetched successfully!',
            'profile' => new UserProfileResource($profile),
        ]);
    }

    /**
     * Update the authenticated user's profile information.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the profile data to be updated.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message and the updated profile resource.
     */
    public function updateInformation(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($request->has('username')) {
            $existingUser = User::where('username', $request->username)
                ->where('id', '!=', $user->id)
                ->first();

            if ($existingUser) {
                return new JsonResponse([
                    'message' => 'The username is already taken. Please choose a different one.',
                ], 409);
            }

            $user->update(['username' => $request->username]);
        }

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['user_id' => $user->id]);
        }

        $profile->update($request->all());

        return new JsonResponse([
            'message' => 'Profile updated successfully',
            'profile' => new UserProfileResource($profile),
        ]);
    }


    /**
     * Get the authenticated user's social media information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSocialMedia(): JsonResponse
    {
        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['user_id' => $user->id]);
        }

        return new JsonResponse([
            'message' => 'User\'s social media information fetched successfully!',
            'profile' => new UserSocialMediaResource($profile),
        ]);
    }

    /**
     * Update social media accounts for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSocialMedia(Request $request): JsonResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([['user_id' => $user->id]]);
        }

        $profile->update($request->all());

        return new JsonResponse([
            'message' => 'Social media accounts updated successfully',
            'profile' => new UserSocialMediaResource($profile),
        ]);
    }
}
