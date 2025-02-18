<?php

namespace App\Http\Requests\StripePayment;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'name' => 'required|string|max:255',
            'interval_count' => 'required|integer|min:1',
            'billing_period' => 'required|string|in:day,week,month,year',
            'active' => 'required|boolean',
            'number_of_listings' => 'required|min:0',
            'number_of_images' => 'required|min:0',
        ];
    }
}
