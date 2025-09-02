<?php

namespace App\Http\Requests\Transport;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportRequest extends FormRequest
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
            'route_name' => 'sometimes|string|max:255',
            'transport_type' => 'sometimes|in:bus,metro,train,tram',
            'start_station' => 'sometimes|string|max:255',
            'end_station' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'operating_hours' => 'sometimes|array',
            'operating_hours.weekdays' => 'sometimes|string',
            'operating_hours.weekends' => 'sometimes|string',
            'frequency' => 'sometimes|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'route_name.string' => 'The route name must be a string.',
            'route_name.max' => 'The route name may not be greater than 255 characters.',
            'transport_type.in' => 'The transport type must be one of: bus, metro, train, tram.',
            'start_station.string' => 'The start station must be a string.',
            'start_station.max' => 'The start station may not be greater than 255 characters.',
            'end_station.string' => 'The end station must be a string.',
            'end_station.max' => 'The end station may not be greater than 255 characters.',
            'latitude.numeric' => 'The latitude must be a number.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.numeric' => 'The longitude must be a number.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'operating_hours.array' => 'The operating hours must be an array.',
            'frequency.string' => 'The frequency must be a string.',
            'frequency.max' => 'The frequency may not be greater than 255 characters.',
        ];
    }
}
