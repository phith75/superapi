<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinanceRequest extends FormRequest
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
            'type' => 'required|in:gold,currency,fuel',
            'name' => 'required|string|max:255',
            'current_price' => 'required|numeric|min:0',
            'previous_price' => 'required|numeric|min:0',
            'change_percentage' => 'required|numeric',
            'last_updated' => 'required|date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'The finance type is required.',
            'type.in' => 'The finance type must be one of: gold, currency, fuel.',
            'name.required' => 'The finance name is required.',
            'current_price.required' => 'The current price is required.',
            'current_price.numeric' => 'The current price must be a number.',
            'current_price.min' => 'The current price must be greater than or equal to 0.',
            'previous_price.required' => 'The previous price is required.',
            'previous_price.numeric' => 'The previous price must be a number.',
            'previous_price.min' => 'The previous price must be greater than or equal to 0.',
            'change_percentage.required' => 'The change percentage is required.',
            'change_percentage.numeric' => 'The change percentage must be a number.',
            'last_updated.required' => 'The last updated timestamp is required.',
            'last_updated.date' => 'The last updated must be a valid date.',
        ];
    }
}
