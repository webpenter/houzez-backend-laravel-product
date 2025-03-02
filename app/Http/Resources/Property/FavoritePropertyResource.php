<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoritePropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstImage = $this->property->images->first();

        return [
            'id' => $this->id,
            'slug' => $this->property->slug,
            'thumbnail' => is_object($firstImage) ? $firstImage->image_path : null,
            'title' => $this->property->title ?? 'N/A',
            'address' => $this->property->address ?? 'N/A',
            'type' => $this->property->type ?? 'N/A',
            'status' => $this->property->status ?? 'N/A',
            'property_status' => $this->property->property_status ?? null,
            'price' => $this->property->price ?? 0,
            'featured' => $this->property->featured ?? false,
        ];
    }
}
