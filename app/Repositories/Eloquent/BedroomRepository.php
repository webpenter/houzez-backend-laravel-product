<?php

namespace App\Repositories\Eloquent;

use App\Models\Bedroom;
use App\Repositories\BedroomRepositoryInterface;

class BedroomRepository implements BedroomRepositoryInterface
{
    public function getAll()
    {
        return Bedroom::all();
    }

    public function create(array $data): Bedroom
    {
        return Bedroom::create($data);
    }

    public function findById(int $id): ?Bedroom
    {
        return Bedroom::find($id);
    }

    public function update(Bedroom $bedroom, array $data): Bedroom
    {
        $bedroom->update($data);
        return $bedroom;
    }

    public function delete(Bedroom $bedroom): void
    {
        $bedroom->delete();
    }
}