<?php

namespace App\Repositories;

use App\Models\Bedroom;

interface BedroomRepositoryInterface
{
    public function getAll();
    public function create(array $data): Bedroom;
    public function findById(int $id): ?Bedroom;
    public function update(Bedroom $bedroom, array $data): Bedroom;
    public function delete(Bedroom $bedroom): void;
}
