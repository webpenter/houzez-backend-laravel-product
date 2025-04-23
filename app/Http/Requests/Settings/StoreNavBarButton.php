<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreNavBarButton extends FormRequest
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
            'name' => 'required|string|max:255',
            'path' => 'required|string',
            'text_color' => 'nullable|string|max:7',  // e.g., #ffffff
            'bg_color' => 'nullable|string|max:7',    // e.g., #000000
            'is_visible' => 'required|boolean',
        ];
    }
}
