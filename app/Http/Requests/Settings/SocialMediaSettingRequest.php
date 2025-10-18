<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Optional validation for social media URLs
            'facebook.value'      => 'nullable|url|max:255',
            'twitter.value'       => 'nullable|url|max:255',
            'linkedin.value'      => 'nullable|url|max:255',
            'instagram.value'     => 'nullable|url|max:255',
            'google_plus.value'   => 'nullable|url|max:255',
            'youtube.value'       => 'nullable|url|max:255',
            'pinterest.value'     => 'nullable|url|max:255',
            'vimeo.value'         => 'nullable|url|max:255',
            'skype.value'         => 'nullable|string|max:255',
            'website.value'       => 'nullable|url|max:255',
            '*.is_visible'        => 'nullable|boolean',
        ];
    }
}
