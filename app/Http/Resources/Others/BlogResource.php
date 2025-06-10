<?php

namespace App\Http\Resources\Others;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class   BlogResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'date' => formatDate($this->created_at),
        ];
    }
}
