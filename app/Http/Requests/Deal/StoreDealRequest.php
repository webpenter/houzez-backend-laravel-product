<?php

namespace App\Http\Requests\Deal;

use App\Enums\DealGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDealRequest extends FormRequest
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
            'group' => ['required', new Enum(DealGroup::class)],
            'title' => ['required', 'string'],
            'contact_name' => ['required', 'string'],
            'agent' => ['required', 'string'],
            'deal_value' => ['required', 'numeric'],
            'status' => ['required', 'string'],
        ];
    }
}
