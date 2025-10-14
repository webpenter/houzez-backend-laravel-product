<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserProfileRepositoryInterface;

/**
 * Class UserProfileRepository
 *
 * Handles all user profile-related database operations using Eloquent ORM.
 */
class UserProfileRepository implements UserProfileRepositoryInterface
{
    /**
     * Retrieve the authenticated user's profile information.
     *
     * @return \App\Models\Profile
     */
    public function getProfileInformation()
    {
        $user = Auth::user();
        return $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
    }

    /**
     * Update the authenticated user's profile information.
     *
     * @param array $data The validated profile data.
     * @return \App\Models\Profile
     */
    public function updateInformation(array $data)
    {
        $user = Auth::user();

        // Check if username already exists for another user
        if (isset($data['username'])) {
            $existing = User::where('username', $data['username'])
                ->where('id', '!=', $user->id)
                ->first();

            if ($existing) {
                abort(409, 'The username is already taken. Please choose a different one.');
            }

            $user->update(['username' => $data['username']]);
        }

        // Ensure user profile exists
        $profile = $user->profile ?? $user->profile()->create(['user_id' => $user->id]);

        // Update profile fields
        $profile->update($data);

        return $profile;
    }

    /**
     * Retrieve the authenticated user's profile picture URL.
     *
     * @return string|null
     */
    public function getProfilePicture()
    {
        $user = Auth::user();
        return optional($user->profile)->profile_picture;
    }

    /**
     * Update the authenticated user's profile picture.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded image file.
     * @return string The full URL of the new profile picture.
     */
    public function updateProfilePicture($file)
    {
        $user = Auth::user();

        // Ensure profile exists
        $profile = $user->profile ?? $user->profile()->create([]);

        // Delete old profile picture if exists
        if (!empty($profile->profile_picture)) {
            $oldPath = public_path('profile-picture/' . basename($profile->profile_picture));
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Store new profile picture
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile-picture'), $fileName);

        $fullUrl = url('profile-picture/' . $fileName);
        $profile->update(['profile_picture' => $fullUrl]);

        return $fullUrl;
    }

    /**
     * Retrieve the authenticated user's social media links.
     *
     * @return \App\Models\Profile
     */
    public function getSocialMedia()
    {
        $user = Auth::user();
        return $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
    }

    /**
     * Update the authenticated user's social media links.
     *
     * @param array $data The validated social media fields.
     * @return \App\Models\Profile
     */
    public function updateSocialMedia(array $data)
    {
        $user = Auth::user();

        // Ensure profile exists
        $profile = $user->profile ?? $user->profile()->create(['user_id' => $user->id]);

        // Update social media fields
        $profile->update($data);

        return $profile;
    }
}
