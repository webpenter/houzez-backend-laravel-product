<?php

namespace App\Repositories;

use App\Models\Enquiry;

interface EnquiryRepositoryInterface
{
    public function all();
    public function find(int $id): ?Enquiry;
    public function create(array $data): Enquiry;
    public function delete(int $id): bool;
}
