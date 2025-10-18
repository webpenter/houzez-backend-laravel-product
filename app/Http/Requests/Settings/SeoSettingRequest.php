<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SeoSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta_title'            => 'nullable|string|max:255',
            'meta_description'      => 'nullable|string|max:500',
            'meta_keywords'         => 'nullable|string|max:500',
            'google_analytics_code' => 'nullable|string|max:1000',
            'facebook_pixel_code'   => 'nullable|string|max:1000',
        ];
    }
}
