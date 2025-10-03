<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ContactSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_email.value'     => 'nullable|email',
            'contact_phone.value'     => 'nullable|string|max:20',
            'address.value'           => 'nullable|string|max:255',
            'mobile_number.value'     => 'nullable|string|max:20',
            'whatsapp_number.value'   => 'nullable|string|max:20',
            '*.is_visible'            => 'nullable|boolean',
        ];
    }
}
