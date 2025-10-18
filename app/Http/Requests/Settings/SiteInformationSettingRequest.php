<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SiteInformationSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email.value'        => 'nullable|email|max:191',
            'phone_number.value' => 'nullable|string|max:20',
            'site_name.value'    => 'nullable|string|max:191',
            'site_title.value'   => 'nullable|string|max:191',
            '*.is_visible'       => 'nullable|boolean',
        ];
    }
}
