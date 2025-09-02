<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'route_name' => $this->route_name,
            'transport_type' => $this->transport_type,
            'start_station' => $this->start_station,
            'end_station' => $this->end_station,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'operating_hours' => $this->operating_hours,
            'frequency' => $this->frequency,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
