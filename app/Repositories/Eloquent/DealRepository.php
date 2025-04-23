<?php

namespace App\Repositories\Eloquent;

use App\Models\Deal;
use App\Repositories\DealRepositoryInterface;

class DealRepository implements DealRepositoryInterface
{
    public function all()
    {
        return Deal::all();
    }

    public function find(int $id)
    {
        return Deal::findOrFail($id);
    }

    public function create(array $data)
    {
        return Deal::create($data);
    }

    public function update(int $id, array $data)
    {
        $deal = Deal::findOrFail($id);
        $deal->update($data);
        return $deal;
    }

    public function delete(int $id)
    {
        return Deal::findOrFail($id)->delete();
    }

    public function getByGroup(string $group)
    {
        return Deal::where('group', $group)->get();
    }
}
