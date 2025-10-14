<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfilePictureRequest;
use App\Http\Resources\Auth\UserProfileResource;
use App\Http\Resources\Auth\UserSocialMediaResource;
use App\Repositories\UserProfileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private UserProfileRepositoryInterface $userProfileRepository;

    /**
     * Inject the UserProfileRepositoryInterface.
     */
    public function __construct(UserProfileRepositoryInterface $userProfileRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Get the authenticated user's profile picture URL.
     */
    public function getProfilePicture(): JsonResponse
    {
        $profilePicture = $this->userProfileRepository->getProfilePicture();

        return new JsonResponse([
            'message' => 'Profile picture fetched successfully.',
            'profile_picture_url' => $profilePicture,
        ]);
    }

    /**
     * Update the authenticated user's profile picture.
     */
    public function updateProfilePicture(Request $request): JsonResponse
    {
        // Use request validation class if it exists, otherwise basic validation
        $validated = $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('profile_picture');
        $updatedUrl = $this->userProfileRepository->updateProfilePicture($file);

        return new JsonResponse([
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => $updatedUrl,
        ]);
    }

    /**
     * Get the authenticated user's profile information.
     */
    public function getProfileInformation(): JsonResponse
    {
        $profile = $this->userProfileRepository->getProfileInformation();

        return new JsonResponse([
            'message' => 'Profile information fetched successfully!',
            'profile' => new UserProfileResource($profile),
        ]);
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function updateInformation(Request $request): JsonResponse
    {
        $updatedProfile = $this->userProfileRepository->updateInformation($request->all());

        return new JsonResponse([
            'message' => 'Profile updated successfully!',
            'profile' => new UserProfileResource($updatedProfile),
        ]);
    }

    /**
     * Get the authenticated user's social media information.
     */
    public function getSocialMedia(): JsonResponse
    {
        $profile = $this->userProfileRepository->getSocialMedia();

        return new JsonResponse([
            'message' => 'Social media information fetched successfully!',
            'profile' => new UserSocialMediaResource($profile),
        ]);
    }

    /**
     * Update social media accounts for the authenticated user.
     */
    public function updateSocialMedia(Request $request): JsonResponse
    {
        $updatedProfile = $this->userProfileRepository->updateSocialMedia($request->all());

        return new JsonResponse([
            'message' => 'Social media accounts updated successfully!',
            'profile' => new UserSocialMediaResource($updatedProfile),
        ]);
    }
}
