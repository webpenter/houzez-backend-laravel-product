<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\UploadedFile;

class TeamService
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepo
    ) {}

    /**
     * Store a new team with image in public folder
     *
     * @param array $data
     * @return Team
     */
    public function store(array $data): Team
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $imageName = time() . '_' . $data['image']->getClientOriginalName();
            $data['image']->move(public_path('team-images'), $imageName);
            $data['image'] = asset('team-images/' . $imageName);
        }

        return $this->teamRepo->create($data); // ✅ FIXED
    }

    /**
     * Update team with new image (if provided)
     *
     * @param int $id
     * @param array $data
     * @return Team
     */
    public function update(int $id, array $data): Team
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $imageName = time() . '_' . $data['image']->getClientOriginalName();
            $data['image']->move(public_path('team-images'), $imageName);
            $data['image'] = asset('team-images/' . $imageName);
        }

        return $this->teamRepo->update($id, $data); // ✅ FIXED
    }

    /**
     * Store uploaded image and return full URL.
     *
     * @param UploadedFile $image
     * @return string
     */
    protected function storeImage(UploadedFile $image): string
    {
        $path = $image->store('team-images', 'public');
        return asset('storage/' . $path);
    }
}
