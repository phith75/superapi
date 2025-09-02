<?php

namespace Database\Factories;

use App\Models\Finance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance>
 */
class FinanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Finance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['gold', 'currency', 'fuel'];
        $currentPrice = fake()->randomFloat(2, 100, 10000);
        $previousPrice = $currentPrice + fake()->randomFloat(2, -500, 500);
        $changePercentage = (($currentPrice - $previousPrice) / $previousPrice) * 100;

        return [
            'type' => fake()->randomElement($types),
            'name' => fake()->randomElement([
                'SJC Gold', '24K Gold', 'USD/VND', 'EUR/VND', 'Gasoline A92', 'Gasoline A95'
            ]),
            'current_price' => $currentPrice,
            'previous_price' => $previousPrice,
            'change_percentage' => round($changePercentage, 2),
            'last_updated' => fake()->dateTimeBetween('-1 hour', 'now'),
        ];
    }

    /**
     * Indicate that the finance record is for gold.
     */
    public function gold(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'gold',
            'name' => fake()->randomElement(['SJC Gold', '24K Gold', '18K Gold']),
            'current_price' => fake()->randomFloat(2, 5000, 8000),
        ]);
    }

    /**
     * Indicate that the finance record is for currency.
     */
    public function currency(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'currency',
            'name' => fake()->randomElement(['USD/VND', 'EUR/VND', 'JPY/VND']),
            'current_price' => fake()->randomFloat(2, 20000, 30000),
        ]);
    }
}
