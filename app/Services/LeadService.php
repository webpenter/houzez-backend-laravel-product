<?php

namespace App\Services;

use App\Repositories\LeadRepositoryInterface;

class LeadService
{
    protected LeadRepositoryInterface $leadRepository;

    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function getAllLeads()
    {
        return $this->leadRepository->all();
    }

    public function createLead(array $data)
    {
        return $this->leadRepository->store($data);
    }

    public function getLeadById(int $id)
    {
        return $this->leadRepository->show($id);
    }

    public function updateLead(int $id, array $data)
    {
        return $this->leadRepository->update($id, $data);
    }

    public function deleteLead(int $id)
    {
        return $this->leadRepository->delete($id);
    }
}
