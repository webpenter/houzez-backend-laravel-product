<?php

namespace App\Repositories;

interface LeadRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function show(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
