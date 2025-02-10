<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyAttachmentRequest;
use App\Repositories\PropertyAttachmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PropertyAttachmentController extends Controller
{
    protected $propertyAttachmentRepository;

    /**
     * ### Constructor
     * Injects the PropertyAttachmentRepository for handling file uploads.
     *
     * @param PropertyAttachmentRepositoryInterface $propertyAttachmentRepository
     */
    public function __construct(PropertyAttachmentRepositoryInterface $propertyAttachmentRepository)
    {
        $this->propertyAttachmentRepository = $propertyAttachmentRepository;
    }

    /**
     * ### Store or Update Property Attachments
     * Handles the upload and update of multiple files.
     *
     * **Route:** `POST /api/property-attachments/{property_id}`
     *
     * **Request Payload:**
     * ```json
     * {
     *   "files": [file1, file2, ...]
     * }
     * ```
     *
     * @param PropertyAttachmentRequest $request  - The validated request.
     * @param int $property_id  - The ID of the property.
     * @return JsonResponse
     */
    public function storeOrUpdate(PropertyAttachmentRequest $request, int $property_id): JsonResponse
    {
        return $this->propertyAttachmentRepository->storeOrUpdateFiles($request, $property_id);
    }

    /**
     * ### Get All Attachments for a Property
     * Retrieves all property attachments for a given `property_id`.
     *
     * **Route:** `GET /api/property-attachments/{property_id}`
     *
     * @param int $property_id  - The ID of the property.
     * @return JsonResponse
     */
    public function edit(int $property_id): JsonResponse
    {
        return $this->propertyAttachmentRepository->getAttachmentsByPropertyId($property_id);
    }

    /**
     * ### Delete a Property Attachment
     * Deletes a property attachment and removes its file from `public/property_attachments/`.
     *
     * **Route:** `DELETE /api/property-attachments/{attachment_id}`
     *
     * @param int $attachment_id  - The ID of the attachment.
     * @return JsonResponse
     */
    public function delete(int $attachment_id): JsonResponse
    {
        return $this->propertyAttachmentRepository->deleteAttachment($attachment_id);
    }
}
