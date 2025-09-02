<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficultyLevels = ['easy', 'medium', 'hard'];

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'difficulty_level' => fake()->randomElement($difficultyLevels),
            'time_limit' => fake()->randomElement([15, 30, 45, 60]),
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the quiz is easy.
     */
    public function easy(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty_level' => 'easy',
            'time_limit' => fake()->randomElement([15, 30]),
        ]);
    }

    /**
     * Indicate that the quiz is hard.
     */
    public function hard(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty_level' => 'hard',
            'time_limit' => fake()->randomElement([45, 60]),
        ]);
    }
}
