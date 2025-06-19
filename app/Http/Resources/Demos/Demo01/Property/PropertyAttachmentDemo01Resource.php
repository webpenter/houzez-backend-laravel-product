<?php

namespace App\Http\Resources\Demos\Demo01\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyAttachmentDemo01Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_title' => $this->file_title,
            'file_path' => $this->file_path, // full URL path
        ];
    }
}
