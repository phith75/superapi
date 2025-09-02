<?php

namespace App\Http\Requests\Travel;

use App\Enums\TravelCategory;
use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', TravelCategory::values()),
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image_url' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The travel name is required.',
            'category.required' => 'The travel category is required.',
            'category.in' => 'The selected category is invalid.',
            'address.required' => 'The address is required.',
            'latitude.required' => 'The latitude is required.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.required' => 'The longitude is required.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'image_url.url' => 'The image URL must be a valid URL.',
            'rating.min' => 'The rating must be at least 0.',
            'rating.max' => 'The rating may not be greater than 5.',
        ];
    }
}
