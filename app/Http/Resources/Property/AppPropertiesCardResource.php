<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppPropertiesCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'title' => $this->title ?? null,
            'bedrooms' => $this->bedrooms ?? null,
            'bathrooms' => $this->bathrooms ?? null,
            'area_size' => $this->area_size ?? null,
            'price' => $this->price ?? null,
            'images' => $this->images->select('image_path','is_thumbnail') ?? null,
        ];
    }
}
