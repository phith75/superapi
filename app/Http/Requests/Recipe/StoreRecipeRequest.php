<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'calories' => 'required|integer|min:1|max:2000',
            'image_url' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The recipe title is required.',
            'description.required' => 'The recipe description is required.',
            'calories.required' => 'The calorie count is required.',
            'calories.integer' => 'The calorie count must be a number.',
            'calories.min' => 'The calorie count must be at least 1.',
            'calories.max' => 'The calorie count cannot exceed 2000.',
            'image_url.url' => 'The image URL must be a valid URL.',
        ];
    }
}
