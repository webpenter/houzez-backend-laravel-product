<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mail_driver.value'       => 'required|string|in:smtp,sendmail,mailgun,ses',
            'mail_host.value'         => 'nullable|string|max:191',
            'mail_port.value'         => 'nullable|numeric',
            'mail_username.value'     => 'nullable|string|max:191',
            'mail_password.value'     => 'nullable|string|max:191',
            'mail_from_address.value' => 'nullable|email',
            'mail_from_name.value'    => 'nullable|string|max:191',
            '*.is_visible'            => 'nullable|boolean',
        ];
    }
}
