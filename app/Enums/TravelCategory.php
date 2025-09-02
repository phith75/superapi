<?php

namespace App\Enums;

enum TravelCategory: string
{
    case RESTAURANT = 'restaurant';
    case CAFE = 'cafe';
    case MUSEUM = 'museum';
    case PARK = 'park';
    case OTHER = 'other';

    public static function toArray(): array
    {
        return [
            self::RESTAURANT->value => 'Restaurant',
            self::CAFE->value => 'Cafe',
            self::MUSEUM->value => 'Museum',
            self::PARK->value => 'Park',
            self::OTHER->value => 'Other',
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
