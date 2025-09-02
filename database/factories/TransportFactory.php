<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transportTypes = ['bus', 'metro', 'train', 'tram'];
        $frequencies = ['5 min', '10 min', '15 min', '20 min', '30 min'];

        return [
            'route_name' => fake()->randomElement(['Route A', 'Route B', 'Route C']) . ' ' . fake()->numberBetween(1, 100),
            'transport_type' => fake()->randomElement($transportTypes),
            'start_station' => fake()->city() . ' Station',
            'end_station' => fake()->city() . ' Station',
            'latitude' => fake()->randomFloat(8, 8.0, 23.0), // Vietnam latitude range
            'longitude' => fake()->randomFloat(8, 102.0, 110.0), // Vietnam longitude range
            'operating_hours' => [
                'weekdays' => '05:00-23:00',
                'weekends' => '06:00-22:00',
            ],
            'frequency' => fake()->randomElement($frequencies),
        ];
    }

    /**
     * Indicate that the transport is a bus.
     */
    public function bus(): static
    {
        return $this->state(fn (array $attributes) => [
            'transport_type' => 'bus',
        ]);
    }

    /**
     * Indicate that the transport is a metro.
     */
    public function metro(): static
    {
        return $this->state(fn (array $attributes) => [
            'transport_type' => 'metro',
        ]);
    }
}
