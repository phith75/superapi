<?php

namespace Tests\Feature\Api\V1;

use App\Models\Transport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransportTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_transport_routes(): void
    {
        Transport::factory(3)->create();

        $response = $this->getJson('/api/v1/transport');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'route_name',
                        'transport_type',
                        'start_station',
                        'end_station',
                        'latitude',
                        'longitude',
                        'operating_hours',
                        'frequency',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_transport_by_type(): void
    {
        Transport::factory()->bus()->create();
        Transport::factory()->metro()->create();

        $response = $this->getJson('/api/v1/transport?transport_type=bus');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_creates_transport_route_with_valid_payload(): void
    {
        $data = [
            'route_name' => 'Route A 101',
            'transport_type' => 'bus',
            'start_station' => 'Ho Chi Minh Central Station',
            'end_station' => 'District 1 Station',
            'latitude' => 10.12345678,
            'longitude' => 106.12345678,
            'operating_hours' => [
                'weekdays' => '05:00-23:00',
                'weekends' => '06:00-22:00',
            ],
            'frequency' => '10 min',
        ];

        $response = $this->postJson('/api/v1/transport', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.route_name', 'Route A 101')
            ->assertJsonPath('data.transport_type', 'bus');

        $this->assertDatabaseHas('routes', [
            'route_name' => 'Route A 101',
            'transport_type' => 'bus',
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/transport', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['route_name', 'transport_type', 'start_station', 'end_station', 'latitude', 'longitude', 'operating_hours', 'frequency']);
    }

    public function test_it_validates_transport_type(): void
    {
        $data = [
            'route_name' => 'Route A 101',
            'transport_type' => 'invalid_type',
            'start_station' => 'Ho Chi Minh Central Station',
            'end_station' => 'District 1 Station',
            'latitude' => 10.12345678,
            'longitude' => 106.12345678,
            'operating_hours' => [
                'weekdays' => '05:00-23:00',
                'weekends' => '06:00-22:00',
            ],
            'frequency' => '10 min',
        ];

        $response = $this->postJson('/api/v1/transport', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['transport_type']);
    }

    public function test_it_shows_transport_route(): void
    {
        $transport = Transport::factory()->create();

        $response = $this->getJson("/api/v1/transport/{$transport->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $transport->id)
            ->assertJsonPath('data.route_name', $transport->route_name);
    }

    public function test_it_updates_transport_route(): void
    {
        $transport = Transport::factory()->create();
        $updateData = [
            'route_name' => 'Updated Route Name',
            'frequency' => '15 min',
        ];

        $response = $this->putJson("/api/v1/transport/{$transport->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.route_name', 'Updated Route Name')
            ->assertJsonPath('data.frequency', '15 min');

        $this->assertDatabaseHas('routes', [
            'id' => $transport->id,
            'route_name' => 'Updated Route Name',
        ]);
    }

    public function test_it_deletes_transport_route(): void
    {
        $transport = Transport::factory()->create();

        $response = $this->deleteJson("/api/v1/transport/{$transport->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('routes', ['id' => $transport->id]);
    }

    public function test_it_returns_404_for_nonexistent_transport(): void
    {
        $response = $this->getJson('/api/v1/transport/999');

        $response->assertStatus(404);
    }
}
