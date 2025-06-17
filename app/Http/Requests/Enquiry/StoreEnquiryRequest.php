<?php

namespace App\Http\Requests\Enquiry;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
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
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'phone'  => 'required|string|max:20',
            'type'   => 'required|string|max:100',
            'source' => 'required|string|max:100',
        ];
    }
}
