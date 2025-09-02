<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'finance_records';

    protected $fillable = [
        'type',
        'name',
        'current_price',
        'previous_price',
        'change_percentage',
        'last_updated',
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'previous_price' => 'decimal:2',
        'change_percentage' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    public function scopeByType($query, ?string $type)
    {
        if ($type) {
            $query->where('type', $type);
        }

        return $query;
    }

    public function scopeRecentlyUpdated($query, int $hours = 24)
    {
        return $query->where('last_updated', '>=', now()->subHours($hours));
    }
}
