<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title ?? null,
            'description' => $this->description ?? null,
            'type' => $this->type ?? null,
            'status' => $this->status ?? null,
            'label' => $this->label ?? null,
            'price' => $this->price ?? null,
            'second_price' => $this->second_price ?? null,
            'after_price' => $this->after_price ?? null,
            'price_prefix' => $this->price_prefix ?? null,
            'bedrooms' => $this->bedrooms ?? null,
            'bathrooms' => $this->bathrooms ?? null,
            'garages' => $this->garages ?? null,
            'garages_size' => $this->garages_size ?? null,
            'area_size' => $this->area_size ?? null,
            'size_prefix' => $this->size_prefix ?? null,
            'land_area' => $this->land_area ?? null,
            'land_area_size_postfix' => $this->land_area_size_postfix ?? null,
            'property_id' => $this->property_id ?? null,
            'year_built' => $this->year_built ?? null,
            'property_feature' => $this->property_feature ?? null,
            'energy_class' => $this->energy_class ?? null,
            'global_energy_performance_index' => $this->global_energy_performance_index ?? null,
            'renewable_energy_performance_index' => $this->renewable_energy_performance_index ?? null,
            'energy_performance_of_the_building' => $this->energy_performance_of_the_building ?? null,
            'address' => $this->address ?? null,
            'country' => $this->country ?? null,
            'county_state' => $this->county_state ?? null,
            'city' => $this->city ?? null,
            'neighborhood' => $this->neighborhood ?? null,
            'zip_postal_code' => $this->zip_postal_code ?? null,
            'map_street_view' => $this->map_street_view ?? null,
            'latitude' => $this->latitude ?? null,
            'longitude' => $this->longitude ?? null,
            'video_url' => $this->video_url ?? null,
            'virtual_tour' => $this->virtual_tour ?? null,
            'contact_information' => $this->contact_information ?? null,
            'private_note' => $this->private_note ?? null,
        ];
    }
}
