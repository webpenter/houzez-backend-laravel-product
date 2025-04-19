<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'inquiry_type' => 'required|in:purchase,sell,rent,miss,evaluation,mortgage',
            'information_type' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'property_type' => 'nullable|string|max:255',
            'max_price' => 'nullable|numeric',
            'min_size' => 'nullable|integer',
            'beds' => 'nullable|integer',
            'baths' => 'nullable|integer',
            'message' => 'nullable|string',
        ];
    }
}
