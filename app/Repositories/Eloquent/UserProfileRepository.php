<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserProfileRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Str;

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

        // ✅ Delete old file if exists
        if (!empty($profile->profile_picture)) {
            $oldFilePath = str_replace(url('/') . '/storage/', '', $profile->profile_picture);
            Storage::disk('public')->delete($oldFilePath);
        }

        // ✅ Get original file name and make it unique
        $originalName = $file->getClientOriginalName(); // e.g. 'photo.png'
        $uniqueFileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        // ✅ Store using original name (inside storage/app/public/profile_picture)
        $path = $file->storeAs('profile_picture', $uniqueFileName, 'public');

        // ✅ Generate full URL with domain
        $fullUrl = url('storage/' . $path);

        // ✅ Update database
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
