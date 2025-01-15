<?php

namespace App\Http\Controllers;

use App\Http\Resources\Auth\UserProfileResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Get the authenticated user's profile information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileInformation()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return new UserProfileResource($profile);
    }

    /**
     * Update the authenticated user's profile information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInformation(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        if ($request->hasFile('profile_picture')) {
            $this->handleProfilePictureUpload($profile, $request->file('profile_picture'));
        }

        $profile->update($request->except('profile_picture'));

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile,
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
       
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        $profile->update($request->only([
            'facebook', 'twitter', 'linkedin', 'instagram', 'google_plus',
            'youtube', 'pinterest', 'vimeo', 'skype', 'website',
        ]));

        return response()->json([
            'message' => 'Social media accounts updated successfully',
            'social_media' => $profile->only([
                'facebook', 'twitter', 'linkedin', 'instagram', 'google_plus',
                'youtube', 'pinterest', 'vimeo', 'skype', 'website',
            ]),
        ]);
    }

    /**
     * Handle the profile picture upload and storage.
     *
     * @param UserProfile $profile
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    protected function handleProfilePictureUpload(UserProfile $profile, $file): void
    {
        if ($profile->profile_picture && Storage::exists($profile->profile_picture)) {
            Storage::delete($profile->profile_picture);
        }

        $profile->profile_picture = $file->store('profile_pictures');
    }

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
            'profile' => new UserProfileResource($profile),
        ], 200);
    }

}
