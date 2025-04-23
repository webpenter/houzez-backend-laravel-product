<?php

namespace App\Repositories;

interface NavbarButtonRepositoryInterface
{
    public function getAllVisibleButtons();
    public function getButtonById($id);
    public function createButton(array $data);
    public function updateButton($id, array $data);
    public function deleteButton($id);
}
