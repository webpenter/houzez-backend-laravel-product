<?php

namespace App\Http\Resources\Demos\Demo01\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppPropertyCardDemo01Resource extends JsonResource
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
            'price_prefix' => $this->price_prefix ?? null,
            'after_price' => $this->after_price ?? null,
            'size_prefix' => $this->size_prefix ?? null,
            'second_price' => $this->second_price ?? null,
            'address' => $this->address ?? null,
            'country' => $this->country ?? null,
            'county_state' => $this->county_state ?? null,
            'city' => $this->city ?? null,
            'label' => $this->label ?? null,
            'type' => $this->type ?? null,
            'status' => $this->status ?? null,
            'is_featured' => $this->is_featured ?? null,
            'thumbnail' => $this->images->where('is_thumbnail','1')->pluck('image_path')->first() ?? null,

            'created_ago' => $this->created_at ? $this->created_at->diffForHumans() : null,
            'user' => [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            ],
        ];
    }
}
