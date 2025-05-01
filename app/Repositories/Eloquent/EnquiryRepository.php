<?php

namespace App\Repositories\Eloquent;

use App\Models\Enquiry;
use App\Repositories\EnquiryRepositoryInterface;

class EnquiryRepository implements EnquiryRepositoryInterface
{
    public function all()
    {
        return Enquiry::latest()->get();
    }

    public function find(int $id): ?Enquiry
    {
        return Enquiry::find($id);
    }

    public function create(array $data): Enquiry
    {
        return Enquiry::create($data);
    }

    public function delete(int $id): bool
    {
        $enquiry = Enquiry::find($id);
        return $enquiry ? $enquiry->delete() : false;
    }
}
