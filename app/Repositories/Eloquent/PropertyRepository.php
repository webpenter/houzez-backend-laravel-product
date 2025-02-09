<?php

namespace App\Repositories\Eloquent;

use App\Models\Property;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PropertyRepository implements PropertyRepositoryInterface
{
    /**
     * ## Get User Properties
     *
     * Retrieves all properties associated with a given user.
     *
     * @param int $userId The ID of the user whose properties are to be retrieved.
     * @return Collection A collection of Property models.
     */
    public function getUserProperties(int $userId): Collection
    {
        return Property::whereUserId($userId)->get();
    }

    /**
     * ## Create or Update Property
     *
     * - If an ID is provided, updates the existing property.
     * - If no ID is provided, creates a new property.
     * - Ensures that the authenticated user is the owner before updating.
     *
     * @param array $data The validated property data.
     * @param int|null $id The ID of the property to update (optional).
     * @return Property The created or updated Property model.
     * @throws \Exception If the property is not found or unauthorized access is attempted.
     */
    public function createOrUpdate(array $data, ?int $id = null): Property
    {
        $data['user_id'] = Auth::id();
        $data['property_feature'] = $data['property_feature'] ?? [];
        $data['contact_information'] = $data['contact_information'] ?? [];

        if ($id) {
            $property = Property::find($id);
            if (!$property) {
                throw new \Exception('Property not found.', 404);
            }

            if ($property->user_id !== Auth::id()) {
                throw new \Exception('You are not authorized to update this property.', 403);
            }

            $property->update($data);
        } else {
            $property = Property::create($data);
        }

        return $property;
    }

    /**
     * ## Get Property for Editing
     *
     * Retrieves a single property to edit, ensuring the authenticated user is the owner.
     *
     * @param int $propertyId The ID of the property to retrieve.
     * @return Property The Property model.
     * @throws \Exception If the property is not found or unauthorized access is attempted.
     */
    public function getPropertyForEdit(int $propertyId): Property
    {
        $property = Property::find($propertyId);

        if (!$property) {
            throw new \Exception('Property not found or ID does not match.', 404);
        }

        if ($property->user_id !== Auth::id()) {
            throw new \Exception('You are not authorized to edit this property.', 403);
        }

        return $property;
    }
}
