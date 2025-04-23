<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralSettingRequest extends FormRequest
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
            'logo' => 'nullable|image',
            'bg_image' => 'nullable|image',
            'hero_image' => 'nullable|image',
            'hero_title' => 'nullable|string|max:255',
            'hero_caption' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'email_1' => 'nullable|email',
            'email_2' => 'nullable|email',
            'footer_caption' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ];
    }
}
