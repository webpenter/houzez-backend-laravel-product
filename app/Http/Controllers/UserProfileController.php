<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
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
}
