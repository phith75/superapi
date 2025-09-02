<?php

namespace App\Models;

use App\Enums\TravelCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'travels';

    protected $fillable = [
        'name',
        'category',
        'address',
        'latitude',
        'longitude',
        'image_url',
        'rating',
    ];

    protected $casts = [
        'category' => TravelCategory::class,
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:1',
    ];

    public function scopeFilterByCategory($query, ?string $category)
    {
        if ($category && in_array($category, TravelCategory::values())) {
            $query->where('category', $category);
        }

        return $query;
    }
}
