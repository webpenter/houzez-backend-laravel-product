<?php

namespace App\Repositories\Eloquent;

use App\Models\PropertyAttachment;
use App\Repositories\PropertyAttachmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class PropertyAttachmentRepository implements PropertyAttachmentRepositoryInterface
{
    /**
     * ### Store or Update Property Attachments
     * - Uploads files to `public/property_attachments/`
     * - Stores the file URL in the database
     * - Updates the file if it already exists
     *
     * @param Request $request  - The request containing the uploaded files.
     * @param int $property_id  - The ID of the property (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateFiles(Request $request, int $property_id)
    {
        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $destinationPath = public_path('property_attachments');

            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $uniqueFileName = $originalFileName . '_' . time() . '.' . $fileExtension;

            $file->move($destinationPath, $uniqueFileName);

            $fileUrl = url('property_attachments/' . $uniqueFileName);

            $formattedFileTitle = "This is a " . strtoupper($fileExtension) . " file (" . $originalFileName . ")";

            $propertyAttachment = PropertyAttachment::updateOrCreate(
                ['property_id' => $property_id, 'file_title' => $formattedFileTitle],
                ['file_path' => $fileUrl]
            );

            $uploadedFiles[] = $propertyAttachment;
        }

        return response()->json([
            'status' => true,
            'message' => 'Files uploaded successfully',
            'data' => $uploadedFiles,
        ], 200);
    }

    /**
     * ### Get All Attachments for a Property
     * Fetches all property attachments for a specific `property_id`.
     *
     * @param int $property_id  - The ID of the property (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttachmentsByPropertyId(int $property_id)
    {
        $attachments = PropertyAttachment::where('property_id', $property_id)->get();

        if ($attachments->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No attachments found for this property',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Property attachments retrieved successfully',
            'data' => $attachments
        ], 200);
    }

    /**
     * ### Delete a Property Attachment
     * Removes the attachment record from the database and deletes the file from `public/property_attachments/`
     *
     * @param int $attachment_id  - The ID of the attachment (passed in the URL).
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttachment(int $attachment_id)
    {
        $attachment = PropertyAttachment::find($attachment_id);

        if (!$attachment) {
            return response()->json([
                'status' => false,
                'message' => 'Attachment not found',
            ], 404);
        }

        $filePath = public_path(parse_url($attachment->file_path, PHP_URL_PATH));

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $attachment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Attachment deleted successfully',
        ], 200);
    }
}
