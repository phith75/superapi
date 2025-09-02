<?php

namespace Tests\Feature\Api\V1;

use App\Enums\TravelCategory;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_travels(): void
    {
        Travel::factory(3)->create();

        $response = $this->getJson('/api/v1/travel');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'category',
                        'category_label',
                        'address',
                        'latitude',
                        'longitude',
                        'image_url',
                        'rating',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_travels_by_category(): void
    {
        Travel::factory()->create(['category' => TravelCategory::RESTAURANT]);
        Travel::factory()->create(['category' => TravelCategory::CAFE]);
        Travel::factory()->create(['category' => TravelCategory::MUSEUM]);

        $response = $this->getJson('/api/v1/travel?category=restaurant');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.category', 'restaurant');
    }

    public function test_it_creates_travel_with_valid_payload(): void
    {
        $data = [
            'name' => 'Test Restaurant',
            'category' => 'restaurant',
            'address' => '123 Test Street',
            'latitude' => 10.12345678,
            'longitude' => 106.12345678,
            'image_url' => 'https://example.com/image.jpg',
            'rating' => 4.5,
        ];

        $response = $this->postJson('/api/v1/travel', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Test Restaurant')
            ->assertJsonPath('data.category', 'restaurant');

        $this->assertDatabaseHas('travels', [
            'name' => 'Test Restaurant',
            'category' => 'restaurant',
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/travel', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'category', 'address', 'latitude', 'longitude']);
    }

    public function test_it_shows_travel(): void
    {
        $travel = Travel::factory()->create();

        $response = $this->getJson("/api/v1/travel/{$travel->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $travel->id)
            ->assertJsonPath('data.name', $travel->name);
    }

    public function test_it_updates_travel(): void
    {
        $travel = Travel::factory()->create();
        $updateData = [
            'name' => 'Updated Name',
            'rating' => 5.0,
        ];

        $response = $this->putJson("/api/v1/travel/{$travel->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Name')
            ->assertJsonPath('data.rating', '5.0');

        $this->assertDatabaseHas('travels', [
            'id' => $travel->id,
            'name' => 'Updated Name',
            'rating' => 5.0,
        ]);
    }

    public function test_it_deletes_travel(): void
    {
        $travel = Travel::factory()->create();

        $response = $this->deleteJson("/api/v1/travel/{$travel->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('travels', ['id' => $travel->id]);
    }

    public function test_it_returns_404_for_nonexistent_travel(): void
    {
        $response = $this->getJson('/api/v1/travel/999');

        $response->assertStatus(404);
    }
}
