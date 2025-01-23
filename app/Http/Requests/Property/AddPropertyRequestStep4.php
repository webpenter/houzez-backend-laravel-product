<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class AddPropertyRequestStep4 extends FormRequest
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
            // Step 4: Energy Class
            'energy_class' => 'nullable|string|max:255',
            'global_energy_performance_index' => 'nullable|string|max:255',
            'renewable_energy_performance_index' => 'nullable|string|max:255',
            'energy_performance_of_the_building' => 'nullable|string|max:255',
        ];
    }
}
