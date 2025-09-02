<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'calories' => 'sometimes|integer|min:1|max:2000',
            'image_url' => 'sometimes|nullable|url|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.string' => 'The recipe title must be a string.',
            'title.max' => 'The recipe title may not be greater than 255 characters.',
            'description.string' => 'The recipe description must be a string.',
            'calories.integer' => 'The calorie count must be a number.',
            'calories.min' => 'The calorie count must be at least 1.',
            'calories.max' => 'The calorie count cannot exceed 2000.',
            'image_url.url' => 'The image URL must be a valid URL.',
        ];
    }
}
