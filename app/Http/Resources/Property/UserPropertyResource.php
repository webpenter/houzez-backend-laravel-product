<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPropertyResource extends JsonResource
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
            'address' => $this->address ?? null,
            'type' => $this->type ?? null,
            'status' => $this->status ?? null,
            'property_status' => $this->property_status ?? "draft",
            'is_paid' => $this->is_paid ?? false,
            'price' => $this->price ?? null,
            'thumbnail' => $this->images->where('is_thumbnail','1')->pluck('image_path')->first() ?? null,
        ];
    }
}
