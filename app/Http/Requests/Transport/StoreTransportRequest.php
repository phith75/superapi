<?php

namespace App\Http\Requests\Transport;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportRequest extends FormRequest
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
            'route_name' => 'required|string|max:255',
            'transport_type' => 'required|in:bus,metro,train,tram',
            'start_station' => 'required|string|max:255',
            'end_station' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'operating_hours' => 'required|array',
            'operating_hours.weekdays' => 'required|string',
            'operating_hours.weekends' => 'required|string',
            'frequency' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'route_name.required' => 'The route name is required.',
            'transport_type.required' => 'The transport type is required.',
            'transport_type.in' => 'The transport type must be one of: bus, metro, train, tram.',
            'start_station.required' => 'The start station is required.',
            'end_station.required' => 'The end station is required.',
            'latitude.required' => 'The latitude is required.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.required' => 'The longitude is required.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'operating_hours.required' => 'The operating hours are required.',
            'operating_hours.array' => 'The operating hours must be an array.',
            'frequency.required' => 'The frequency is required.',
        ];
    }
}
