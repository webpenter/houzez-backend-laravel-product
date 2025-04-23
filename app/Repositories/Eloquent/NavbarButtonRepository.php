<?php

namespace App\Repositories\Eloquent;

use App\Models\NavbarButton;
use App\Repositories\NavbarButtonRepositoryInterface;

class NavbarButtonRepository implements NavbarButtonRepositoryInterface
{
    /**
     * Get all visible navbar buttons.
     */
    public function getAllVisibleButtons()
    {
        return NavbarButton::where('is_visible', true)->get();
    }

    /**
     * Get a single navbar button by ID.
     */
    public function getButtonById($id)
    {
        return NavbarButton::find($id);
    }

    /**
     * Create and store a new navbar button.
     */
    public function createButton(array $data)
    {
        return NavbarButton::create($data);
    }

    /**
     * Update an existing navbar button by ID.
     */
    public function updateButton($id, array $data)
    {
        $navbarButton = NavbarButton::find($id);

        if ($navbarButton) {
            $navbarButton->update($data);
        }

        return $navbarButton;
    }

    /**
     * Delete a navbar button by ID.
     */
    public function deleteButton($id)
    {
        $navbarButton = NavbarButton::find($id);

        if ($navbarButton) {
            $navbarButton->delete();
        }

        return $navbarButton;
    }
}
