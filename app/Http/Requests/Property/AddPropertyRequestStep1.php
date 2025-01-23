<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class AddPropertyRequestStep1 extends FormRequest
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
        ];
    }
}
