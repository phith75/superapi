<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'routes';

    protected $fillable = [
        'route_name',
        'transport_type',
        'start_station',
        'end_station',
        'latitude',
        'longitude',
        'operating_hours',
        'frequency',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'operating_hours' => 'array',
    ];

    public function scopeFilterByType($query, ?string $type)
    {
        if ($type) {
            $query->where('transport_type', $type);
        }

        return $query;
    }

    public function scopeNearby($query, float $lat, float $lng, float $radius = 5.0)
    {
        // Simple distance calculation (Haversine formula would be better for production)
        $query->whereRaw('
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) <= ?
        ', [$lat, $lng, $lat, $radius]);

        return $query;
    }
}
