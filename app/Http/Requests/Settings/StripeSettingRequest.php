<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StripeSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stripe_public_key.value'  => 'required|string',
            'stripe_private_key.value' => 'required|string',
            'currency.value'           => 'required|string|max:5',
            '*.is_visible'             => 'nullable|boolean',
        ];
    }
}
