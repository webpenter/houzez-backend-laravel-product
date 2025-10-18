<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserProfileRepositoryInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function getProfileInformation()
    {
        $user = Auth::user();
        return $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
    }

    public function updateInformation(array $data)
    {
        $user = Auth::user();

        if (isset($data['username'])) {
            $existing = User::where('username', $data['username'])
                ->where('id', '!=', $user->id)
                ->first();

            if ($existing) {
                abort(409, 'The username is already taken. Please choose a different one.');
            }

            $user->update(['username' => $data['username']]);
        }

        $profile = $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
        $profile->update($data);

        return $profile;
    }

    public function getProfilePicture()
    {
        $user = Auth::user();
        return optional($user->profile)->profile_picture;
    }

    public function updateProfilePicture($file)
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);

        // Delete old picture if exists
        if (!empty($profile->profile_picture)) {
            $oldPath = public_path('profile-picture/' . basename($profile->profile_picture));
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile-picture'), $fileName);

        $fullUrl = url('profile-picture/' . $fileName);
        $profile->update(['profile_picture' => $fullUrl]);

        return $fullUrl;
    }

    public function getSocialMedia()
    {
        $user = Auth::user();
        return $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
    }

    public function updateSocialMedia(array $data)
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create(['user_id' => $user->id]);
        $profile->update($data);

        return $profile;
    }
}
