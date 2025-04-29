<?php

namespace App\Repositories\Eloquent;

use App\Models\Team;
use Illuminate\Support\Collection;
use App\Repositories\TeamRepositoryInterface;

class TeamRepository implements TeamRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Team::latest()->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): Team
    {
        return Team::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Team
    {
        return Team::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): Team
    {
        $team = $this->find($id);
        $team->update($data);
        return $team;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $team = $this->find($id);
        return $team->delete();
    }

    /**
     * @inheritDoc
     */
    public function app(): Collection
    {
        return Team::latest()->take(10)->get();
    }
}
