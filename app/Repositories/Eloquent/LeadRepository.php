<?php

namespace App\Repositories\Eloquent;

use App\Models\Lead;
use App\Repositories\LeadRepositoryInterface;

class LeadRepository implements LeadRepositoryInterface
{
    public function all()
    {
        return Lead::latest()->get();
    }

    public function store(array $data)
    {
        return Lead::create($data);
    }

    public function show(int $id)
    {
        return Lead::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($data);
        return $lead;
    }

    public function delete(int $id)
    {
        $lead = Lead::findOrFail($id);
        return $lead->delete();
    }
}
