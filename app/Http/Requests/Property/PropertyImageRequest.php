<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class PropertyImageRequest extends FormRequest
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'required|array|min:1|max:6',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Please upload at least one image.',
            'images.array' => 'Images must be an array.',
            'images.min' => 'You must upload at least 1 image.',
            'images.max' => 'You can upload a maximum of 6 images.',
            'images.*.required' => 'Each uploaded file must be an image.',
            'images.*.image' => 'Invalid image format.',
            'images.*.mimes' => 'Only JPEG, PNG, JPG, and GIF formats are allowed.',
            'images.*.max' => 'Each image must be less than 2MB.',
        ];
    }
}
