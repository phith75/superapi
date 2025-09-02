<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'calories',
        'image_url',
    ];

    protected $casts = [
        'calories' => 'integer',
    ];

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function scopeFilterByCalories($query, ?int $maxCalories)
    {
        if ($maxCalories) {
            $query->where('calories', '<=', $maxCalories);
        }

        return $query;
    }
}
