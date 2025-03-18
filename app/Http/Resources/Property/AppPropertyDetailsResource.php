<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppPropertyDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? 'N/A',
            'title' => $this->title ?? 'N/A',
            'slug' => $this->slug ?? 'N/A',
            'address' => $this->address ?? 'N/A',
            'description' => $this->description ?? 'N/A',
            'bedrooms' => $this->bedrooms ?? 'N/A',
            'bathrooms' => $this->bathrooms ?? 'N/A',
            'area_size' => $this->area_size ?? 'N/A',
            'price' => $this->price ?? 'N/A',
            'thumbnail' => $this->images->where('is_thumbnail', '1')->pluck('image_path')->first() ?? null,
            'images' => $this->images->select('id', 'image_path', 'is_thumbnail') ?? null,
            'type' => $this->type ?? 'N/A',
            'status' => $this->status ?? 'N/A',
            'is_featured' => $this->is_featured ?? 'N/A',
            'label' => $this->label ?? 'N/A',
            'second_price' => $this->second_price ?? 'N/A',
            'after_price' => $this->after_price ?? 'N/A',
            'price_prefix' => $this->price_prefix ?? 'N/A',
            'garages' => $this->garages ?? 'N/A',
            'garages_size' => $this->garages_size ?? 'N/A',
            'size_prefix' => $this->size_prefix ?? 'N/A',
            'land_area' => $this->land_area ?? 'N/A',
            'land_area_size_postfix' => $this->land_area_size_postfix ?? 'N/A',
            'property_id' => $this->property_id ?? 'N/A',
            'year_built' => $this->year_built ?? 'N/A',
            'property_feature' => $this->property_feature ?? 'N/A',
            'energy_class' => $this->energy_class ?? 'N/A',
            'global_energy_performance_index' => $this->global_energy_performance_index ?? 'N/A',
            'renewable_energy_performance_index' => $this->renewable_energy_performance_index ?? 'N/A',
            'energy_performance_of_the_building' => $this->energy_performance_of_the_building ?? 'N/A',
            'country' => $this->country ?? 'N/A',
            'county_state' => $this->county_state ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'neighborhood' => $this->neighborhood ?? 'N/A',
            'zip_postal_code' => $this->zip_postal_code ?? 'N/A',
            'map_street_view' => $this->map_street_view ?? null,
            'latitude' => $this->latitude ?? '34.0246242',
            'longitude' => $this->longitude ?? '-118.4108102',
            'video_url' => $this->video_url ?? null,
            'virtual_tour' => $this->virtual_tour ?? null,
            'contact_information' => $this->contact_information ?? null,
        ];
    }
}
