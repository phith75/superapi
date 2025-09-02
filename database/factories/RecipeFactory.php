<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'calories' => fake()->numberBetween(100, 800),
            'image_url' => fake()->optional(0.7)->imageUrl(640, 480, 'food'),
        ];
    }

    /**
     * Indicate that the recipe is low calorie.
     */
    public function lowCalorie(): static
    {
        return $this->state(fn (array $attributes) => [
            'calories' => fake()->numberBetween(100, 300),
        ]);
    }

    /**
     * Indicate that the recipe is high calorie.
     */
    public function highCalorie(): static
    {
        return $this->state(fn (array $attributes) => [
            'calories' => fake()->numberBetween(600, 1000),
        ]);
    }
}
