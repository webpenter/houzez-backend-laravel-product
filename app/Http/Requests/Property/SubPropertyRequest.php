<?php

namespace App\Http\Requests\property;

use Illuminate\Foundation\Http\FormRequest;

class SubPropertyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'garages' => 'nullable|integer',
            'garage_size' => 'nullable|string|max:255',
            'area_size' => 'nullable|integer',
            'size_prefix' => 'nullable|string|max:50',
            'price' => 'nullable|numeric',
            'price_label' => 'nullable|string|max:50',
        ];
    }
}
