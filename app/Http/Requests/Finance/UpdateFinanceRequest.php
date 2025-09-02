<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinanceRequest extends FormRequest
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
            'type' => 'sometimes|in:gold,currency,fuel',
            'name' => 'sometimes|string|max:255',
            'current_price' => 'sometimes|numeric|min:0',
            'previous_price' => 'sometimes|numeric|min:0',
            'change_percentage' => 'sometimes|numeric',
            'last_updated' => 'sometimes|date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'type.in' => 'The finance type must be one of: gold, currency, fuel.',
            'name.string' => 'The finance name must be a string.',
            'name.max' => 'The finance name may not be greater than 255 characters.',
            'current_price.numeric' => 'The current price must be a number.',
            'current_price.min' => 'The current price must be greater than or equal to 0.',
            'previous_price.numeric' => 'The previous price must be a number.',
            'previous_price.min' => 'The previous price must be greater than or equal to 0.',
            'change_percentage.numeric' => 'The change percentage must be a number.',
            'last_updated.date' => 'The last updated must be a valid date.',
        ];
    }
}
