<?php

namespace App\Enums;

enum EventStatus: string
{
    case GOING = 'going';
    case INTERESTED = 'interested';
    case CANCELLED = 'cancelled';

    public static function toArray(): array
    {
        return [
            self::GOING->value => 'Going',
            self::INTERESTED->value => 'Interested',
            self::CANCELLED->value => 'Cancelled',
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
