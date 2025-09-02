<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
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
            'difficulty_level' => 'sometimes|in:easy,medium,hard',
            'time_limit' => 'sometimes|integer|min:1|max:120',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.string' => 'The quiz title must be a string.',
            'title.max' => 'The quiz title may not be greater than 255 characters.',
            'description.string' => 'The quiz description must be a string.',
            'difficulty_level.in' => 'The difficulty level must be one of: easy, medium, hard.',
            'time_limit.integer' => 'The time limit must be a number.',
            'time_limit.min' => 'The time limit must be at least 1 minute.',
            'time_limit.max' => 'The time limit cannot exceed 120 minutes.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
