<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true if no specific authorization logic is needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'package' => 'nullable|string',
            'property_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'country_state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'virtual_tour' => 'nullable|string',
            'private_note' => 'nullable|string',
            'neighborhood' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'map_street_view' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Multiple image validation
            'video_url' => 'nullable|url',
            'address' => 'required|string',
            'features' => 'required|string',
            'features.*' => 'string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'status' => 'nullable|in:draft,published,pending,expired,hold,disapproved',
            'labels' => 'nullable|string',
            'price' => 'required|numeric',
            'second_price' => 'nullable|numeric',
            'after_price_label' => 'nullable|string',
            'price_label' => 'nullable|string|max:255',
            'price_prefix' => 'nullable|string',
            'custom_fields' => 'nullable|string',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'garages_size' => 'nullable|string|max:255',
            'area_size' => 'required|integer|min:0',
            'size_prefix' => 'nullable|string|max:50',
            'land_area' => 'nullable|integer|min:0',
            'land_area_size_postfix' => 'nullable|string|max:50',
            'user_id' => 'required|string|max:50',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'additional_details' => 'nullable|array',
            'additional_details.*.title' => 'required_with:additional_details|string|max:255',
            'additional_details.*.value' => 'required_with:additional_details|string|max:255',
        ];
    }
}
