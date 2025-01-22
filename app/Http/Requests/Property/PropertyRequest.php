<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Step 1: General Details
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'status' => 'required|string|in:published,pending,expired,draft,on-hold,disapproved',
            'label' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'second_price' => 'nullable|numeric|min:0',
            'after_price' => 'nullable|string|max:255',
            'price_prefix' => 'nullable|string|max:255',

            // Step 2: Property Details
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'garages_size' => 'nullable|string|max:255',
            'area_size' => 'required|integer|min:0',
            'size_prefix' => 'nullable|string|max:255',
            'land_area' => 'nullable|integer|min:0',
            'land_area_size_postfix' => 'nullable|string|max:255',
            'property_id' => 'nullable|string|max:255',
            'year_built' => 'nullable|integer|min:0',

            // Step 3: Property Features
            'property_feature' => 'nullable|array',

            // Step 4: Energy Class
            'energy_class' => 'nullable|string|max:255',
            'global_energy_performance_index' => 'nullable|string|max:255',
            'renewable_energy_performance_index' => 'nullable|string|max:255',
            'energy_performance_of_the_building' => 'nullable|string|max:255',

            // Step 5: Location & Map
            'address' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'county_state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'zip_postal_code' => 'nullable|string|max:255',
            'map_street_view' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Step 6: Video URL
            'video_url' => 'nullable|url|max:255',

            // Step 7: Virtual Tour
            'virtual_tour' => 'nullable|string',

            // Step 10: Contact Information
            'contact_information' => 'nullable|array',

            // Step 12: Private Note
            'private_note' => 'nullable|string',
        ];
    }
}
