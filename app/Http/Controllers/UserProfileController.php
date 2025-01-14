<?php

namespace App\Http\Controllers;

use App\Http\Resources\Auth\UserProfileResource;
use App\Http\Resources\Auth\UserSocialMediaResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Retrieve the authenticated user's profile picture URL.
     *
     * @return string|null The URL of the user's profile picture, or null if not set.
     */
    public function getProfilePicture()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile->profile_picture) {
            $profile_picture = $profile->profile_picture;
        } else {
            $profile_picture = null;
        }

        return $profile_picture;
    }

    /**
     * Update the authenticated user's profile picture.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the profile picture file.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message and the URL of the updated profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Limit to 2MB
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the associated profile
        $profile = $user->profile;

        if (!$profile) {
            // If no profile exists, create a new one
            $profile = $user->profile()->create([]);
        }

        // Delete the old picture if it exists
        if (!empty($profile->profile_picture)) {
            $oldPicturePath = public_path('profile-picture/' . basename($profile->profile_picture));
            if (file_exists($oldPicturePath)) {
                unlink($oldPicturePath);
            }
        }

        // Store the new picture
        $file = $request->file('profile_picture');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile-picture'), $fileName);

        // Update the profile picture path
        $fullPath = url('profile-picture/' . $fileName);
        $profile->profile_picture = $fullPath;
        $profile->save();

        // Return a response
        return response()->json([
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => $fullPath,
        ], 200);
    }

    /**
     * Get the authenticated user's profile information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileInformation()
    {
        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['user_id' => $user->id]);
        }

        return response()->json([
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
    public function updateInformation(Request $request)
    {
        $user = Auth::user();

        // Retrieve the associated profile
        $profile = $user->profile;

        if (!$profile) {
            // If no profile exists, create a new one
            $profile = $user->profile()->create([['user_id' => $user->id]]);
        }

        if ($request->has('username')){
            $user->update(['username' => $request->username]);
        }

        $profile->update($request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => new UserProfileResource($profile),
        ]);
    }

    /**
     * Get the authenticated user's social media information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSocialMedia()
    {
        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['user_id' => $user->id]);
        }

        return response()->json([
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
    public function updateSocialMedia(Request $request)
    {
        $user = Auth::user();

        // Retrieve the associated profile
        $profile = $user->profile;

        if (!$profile) {
            // If no profile exists, create a new one
            $profile = $user->profile()->create([['user_id' => $user->id]]);
        }

        $profile->update($request->all());

        return response()->json([
            'message' => 'Social media accounts updated successfully',
            'profile' => new UserSocialMediaResource($profile),
        ]);
    }

}
