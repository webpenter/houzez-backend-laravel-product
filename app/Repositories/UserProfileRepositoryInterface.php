<?php

namespace App\Repositories;

interface UserProfileRepositoryInterface
{
    public function getProfilePicture();

    public function updateProfilePicture($file);

    public function getProfileInformation();

    public function updateInformation(array $data);

    public function getSocialMedia();

    public function updateSocialMedia(array $data);
}
