<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class FloorPlansRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'floorPlans' => 'required|array',
            'floorPlans.*.plan_title' => 'required|string|max:255',
            'floorPlans.*.plan_bedrooms' => 'nullable|integer',
            'floorPlans.*.plan_bathrooms' => 'nullable|integer',
            'floorPlans.*.plan_price' => 'nullable|integer',
            'floorPlans.*.price_postfix' => 'nullable|string|max:15',
            'floorPlans.*.plan_size' => 'nullable|integer',
            'floorPlans.*.plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'floorPlans.*.plan_description' => 'nullable|string|max:255',
        ];
    }
}
