<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface PropertyAttachmentRepositoryInterface
{
    /**
     * ### Store or Update Property Attachments
     * This function uploads multiple files for a given property.
     * If a file with the same title exists, it updates the file path.
     * Otherwise, it creates a new record.
     *
     * @param Request $request  - The request object containing files.
     * @param int $property_id  - The ID of the property (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateFiles(Request $request, int $property_id);

    /**
     * ### Get All Attachments for a Property
     * Fetches all property attachments for a given `property_id`.
     *
     * @param int $property_id  - The ID of the property (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttachmentsByPropertyId(int $property_id);

    /**
     * ### Delete a Property Attachment
     * Deletes the attachment from the database and removes the file from `public/property_attachments/`
     *
     * @param int $attachment_id  - The ID of the attachment (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttachment(int $attachment_id);
}
