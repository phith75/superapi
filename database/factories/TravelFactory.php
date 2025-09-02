<?php

namespace Database\Factories;

use App\Enums\TravelCategory;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Travel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'category' => fake()->randomElement(TravelCategory::cases()),
            'address' => fake()->address(),
            'latitude' => fake()->randomFloat(8, 8.0, 23.0), // Vietnam latitude range
            'longitude' => fake()->randomFloat(8, 102.0, 110.0), // Vietnam longitude range
            'image_url' => fake()->optional(0.7)->imageUrl(640, 480, 'travel'),
            'rating' => fake()->randomFloat(1, 0, 5),
        ];
    }
}
