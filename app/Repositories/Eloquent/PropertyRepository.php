<?php

namespace App\Repositories\Eloquent;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PropertyRepository implements PropertyRepositoryInterface
{
    /**
     * ## Get User Properties
     *
     * Retrieves all properties associated with a given user.
     * Includes optional search and sorting functionality.
     *
     * @param int $userId The ID of the user whose properties are to be retrieved.
     * @param string|null $search The search query for filtering properties (optional).
     * @param string $sortBy The sorting criteria (default: 'default').
     * @return Collection A collection of Property models.
     */
    public function getUserProperties(int $userId, $search = null, $sortBy = 'default', $propertyStatus = null): Collection
    {
        $query = Property::whereUserId($userId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if (!empty($propertyStatus)) {
            $query->where('property_status', $propertyStatus);
        }

        switch ($sortBy) {
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'date_new_old':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_old_new':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->get();
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

    /**
     * ## Delete Property
     *
     * Deletes a property and all its associated images.
     * Ensures that the authenticated user is the owner before deletion.
     *
     * @param int $id The ID of the property to delete.
     * @return bool True if deletion is successful, false otherwise.
     * @throws \Exception If the property is not found or unauthorized access is attempted.
     */
    public function deleteProperty(int $id): bool
    {
        $property = Property::find($id);

        if (!$property) {
            throw new \Exception('Property not found.', 404);
        }

        if ($property->user_id !== Auth::id()) {
            throw new \Exception('You are not authorized to delete this property.', 403);
        }

        $images = PropertyImage::where('property_id', $id)->get();
        foreach ($images as $image) {
            $imagePath = public_path('property_images') . '/' . basename(parse_url($image->image_path, PHP_URL_PATH));

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $image->delete();
        }

        return $property->delete();
    }

    /**
     * ## Duplicate Property
     *
     * Duplicates an existing property along with its images.
     *
     * @param int $id The ID of the property to duplicate.
     * @return Property The duplicated property instance.
     * @throws \Exception If the property is not found.
     */
    public function duplicateProperty(int $id): Property
    {
        $property = Property::find($id);

        if (!$property) {
            throw new \Exception('Property not found.', 404);
        }

        $newProperty = $property->replicate();
        $newProperty->save();

        $images = PropertyImage::where('property_id', $id)->get();
        foreach ($images as $image) {
            $newImage = $image->replicate();
            $newImage->property_id = $newProperty->id;
            $newImage->save();
        }

        return $newProperty;
    }
}
