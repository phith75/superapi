<?php

namespace Tests\Feature\Api\V1;

use App\Models\Finance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_finance_records(): void
    {
        Finance::factory(3)->create();

        $response = $this->getJson('/api/v1/finance');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'name',
                        'current_price',
                        'previous_price',
                        'change_percentage',
                        'last_updated',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_finance_records_by_type(): void
    {
        Finance::factory()->gold()->create();
        Finance::factory()->currency()->create();

        $response = $this->getJson('/api/v1/finance?type=gold');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_filters_recent_finance_records(): void
    {
        Finance::factory()->create(['last_updated' => now()]);
        Finance::factory()->create(['last_updated' => now()->subDays(2)]);

        $response = $this->getJson('/api/v1/finance?recent=1&hours=24');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_creates_finance_record_with_valid_payload(): void
    {
        $data = [
            'type' => 'gold',
            'name' => 'SJC Gold',
            'current_price' => 7500.00,
            'previous_price' => 7400.00,
            'change_percentage' => 1.35,
            'last_updated' => now()->toISOString(),
        ];

        $response = $this->postJson('/api/v1/finance', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.type', 'gold')
            ->assertJsonPath('data.name', 'SJC Gold');

        $this->assertDatabaseHas('finance_records', [
            'type' => 'gold',
            'name' => 'SJC Gold',
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/finance', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type', 'name', 'current_price', 'previous_price', 'change_percentage', 'last_updated']);
    }

    public function test_it_validates_finance_type(): void
    {
        $data = [
            'type' => 'invalid_type',
            'name' => 'Test Record',
            'current_price' => 100.00,
            'previous_price' => 100.00,
            'change_percentage' => 0.00,
            'last_updated' => now()->toISOString(),
        ];

        $response = $this->postJson('/api/v1/finance', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type']);
    }

    public function test_it_validates_price_values(): void
    {
        $data = [
            'type' => 'gold',
            'name' => 'Test Record',
            'current_price' => -100.00,
            'previous_price' => 100.00,
            'change_percentage' => 0.00,
            'last_updated' => now()->toISOString(),
        ];

        $response = $this->postJson('/api/v1/finance', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['current_price']);
    }

    public function test_it_shows_finance_record(): void
    {
        $finance = Finance::factory()->create();

        $response = $this->getJson("/api/v1/finance/{$finance->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $finance->id)
            ->assertJsonPath('data.name', $finance->name);
    }

    public function test_it_updates_finance_record(): void
    {
        $finance = Finance::factory()->create();
        $updateData = [
            'current_price' => 8000.00,
            'change_percentage' => 5.00,
        ];

        $response = $this->putJson("/api/v1/finance/{$finance->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.current_price', '8000.00')
            ->assertJsonPath('data.change_percentage', '5.00');

        $this->assertDatabaseHas('finance_records', [
            'id' => $finance->id,
            'current_price' => 8000.00,
        ]);
    }

    public function test_it_deletes_finance_record(): void
    {
        $finance = Finance::factory()->create();

        $response = $this->deleteJson("/api/v1/finance/{$finance->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('finance_records', ['id' => $finance->id]);
    }

    public function test_it_returns_404_for_nonexistent_finance_record(): void
    {
        $response = $this->getJson('/api/v1/finance/999');

        $response->assertStatus(404);
    }

    public function test_it_gets_gold_prices(): void
    {
        Finance::factory()->gold()->create();
        Finance::factory()->currency()->create();

        $response = $this->getJson('/api/v1/finance/gold/prices');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_gets_currency_rates(): void
    {
        Finance::factory()->currency()->create();
        Finance::factory()->gold()->create();

        $response = $this->getJson('/api/v1/finance/currency/rates');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_gets_fuel_prices(): void
    {
        Finance::factory()->create(['type' => 'fuel']);
        Finance::factory()->gold()->create();

        $response = $this->getJson('/api/v1/finance/fuel/prices');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
