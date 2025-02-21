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
            'slug' => $this->slug ?? null,
            'bedrooms' => $this->bedrooms ?? null,
            'bathrooms' => $this->bathrooms ?? null,
            'area_size' => $this->area_size ?? null,
            'price' => $this->price ?? null,
            'thumbnail' => $this->images->where('is_thumbnail','1')->pluck('image_path')->first() ?? null,
        ];
    }
}
