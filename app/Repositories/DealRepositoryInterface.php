<?php

namespace App\Repositories;

interface DealRepositoryInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();

    /**
     * @param int $id
     * @return \App\Models\Deal
     */
    public function find(int $id);

    /**
     * @param array $data
     * @return \App\Models\Deal
     */
    public function create(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return \App\Models\Deal
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public function getByGroup(string $group);
}
