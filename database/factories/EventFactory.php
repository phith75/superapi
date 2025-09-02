<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('now', '+2 months');
        $endTime = fake()->dateTimeBetween($startTime, '+3 months');

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'location' => fake()->address(),
            'latitude' => fake()->randomFloat(8, 8.0, 23.0), // Vietnam latitude range
            'longitude' => fake()->randomFloat(8, 102.0, 110.0), // Vietnam longitude range
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }

    /**
     * Indicate that the event is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => fake()->dateTimeBetween('now', '+1 month'),
            'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ]);
    }

    /**
     * Indicate that the event is past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'end_time' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
