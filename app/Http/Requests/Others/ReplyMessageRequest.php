<?php

namespace App\Http\Requests\Others;

use Illuminate\Foundation\Http\FormRequest;

class ReplyMessageRequest extends FormRequest
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
            'tour_request_id' => 'required|exists:tour_requests,id',
            'message' => 'required|string|max:500',
        ];
    }
}
