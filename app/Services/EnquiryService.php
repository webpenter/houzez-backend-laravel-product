<?php

namespace App\Services;

use App\Repositories\EnquiryRepositoryInterface;

class EnquiryService
{
    protected EnquiryRepositoryInterface $enquiryRepo;

    public function __construct(EnquiryRepositoryInterface $enquiryRepo)
    {
        $this->enquiryRepo = $enquiryRepo;
    }

    public function getAll()
    {
        return $this->enquiryRepo->all();
    }

    public function getById(int $id)
    {
        return $this->enquiryRepo->find($id);
    }

    public function store(array $data)
    {
        return $this->enquiryRepo->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->enquiryRepo->delete($id);
    }
}
