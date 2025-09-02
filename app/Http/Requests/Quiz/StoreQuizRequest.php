<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'difficulty_level' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:1|max:120',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The quiz title is required.',
            'description.required' => 'The quiz description is required.',
            'difficulty_level.required' => 'The difficulty level is required.',
            'difficulty_level.in' => 'The difficulty level must be one of: easy, medium, hard.',
            'time_limit.required' => 'The time limit is required.',
            'time_limit.integer' => 'The time limit must be a number.',
            'time_limit.min' => 'The time limit must be at least 1 minute.',
            'time_limit.max' => 'The time limit cannot exceed 120 minutes.',
        ];
    }
}
