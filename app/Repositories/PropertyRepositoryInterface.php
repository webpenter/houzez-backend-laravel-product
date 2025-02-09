<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Support\Collection;

interface PropertyRepositoryInterface
{
    /**
     * ## Get User Properties
     *
     * Retrieves all properties associated with a given user.
     *
     * @param int $userId The ID of the user whose properties are to be retrieved.
     * @return Collection A collection of Property models.
     */
    public function getUserProperties(int $userId): Collection;

    /**
     * ## Create or Update Property
     *
     * - If an ID is provided, updates the existing property.
     * - If no ID is provided, creates a new property.
     *
     * @param array $data The validated property data.
     * @param int|null $id The ID of the property to update (optional).
     * @return Property The created or updated Property model.
     */
    public function createOrUpdate(array $data, ?int $id = null): Property;

    /**
     * ## Get Property for Editing
     *
     * Retrieves a single property to edit, ensuring the authenticated user is the owner.
     *
     * @param int $propertyId The ID of the property to retrieve.
     * @return Property The Property model.
     * @throws \Exception If the property is not found or unauthorized access is attempted.
     */
    public function getPropertyForEdit(int $propertyId): Property;
}
