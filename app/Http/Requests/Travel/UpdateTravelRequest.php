<?php

namespace App\Http\Requests\Travel;

use App\Enums\TravelCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:' . implode(',', TravelCategory::values()),
            'address' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'image_url' => 'sometimes|nullable|url|max:255',
            'rating' => 'sometimes|nullable|numeric|min:0|max:5',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The travel name must be a string.',
            'name.max' => 'The travel name may not be greater than 255 characters.',
            'category.in' => 'The selected category is invalid.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'latitude.numeric' => 'The latitude must be a number.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.numeric' => 'The longitude must be a number.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'image_url.url' => 'The image URL must be a valid URL.',
            'image_url.max' => 'The image URL may not be greater than 255 characters.',
            'rating.numeric' => 'The rating must be a number.',
            'rating.min' => 'The rating must be at least 0.',
            'rating.max' => 'The rating may not be greater than 5.',
        ];
    }
}
