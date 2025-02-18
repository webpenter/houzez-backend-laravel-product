<?php

namespace App\Http\Requests\StripePayment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'active' => 'boolean',
            'number_of_listings' => 'required|integer|min:0',
            'number_of_images' => 'required|integer|min:0',
        ];
    }
}
