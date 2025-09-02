<?php

namespace Tests\Feature\Api\V1;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_events(): void
    {
        Event::factory(3)->create();

        $response = $this->getJson('/api/v1/events');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'location',
                        'latitude',
                        'longitude',
                        'start_time',
                        'end_time',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_upcoming_events(): void
    {
        Event::factory()->upcoming()->create();
        Event::factory()->past()->create();

        $response = $this->getJson('/api/v1/events?upcoming=1');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_creates_event_with_valid_payload(): void
    {
        $data = [
            'title' => 'Test Event',
            'description' => 'This is a test event',
            'location' => '123 Test Street',
            'latitude' => 10.12345678,
            'longitude' => 106.12345678,
            'start_time' => now()->addDays(7)->toISOString(),
            'end_time' => now()->addDays(7)->addHours(2)->toISOString(),
        ];

        $response = $this->postJson('/api/v1/events', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Test Event');

        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'location' => '123 Test Street',
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/events', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description', 'location', 'latitude', 'longitude', 'start_time', 'end_time']);
    }

    public function test_it_validates_start_time_in_future(): void
    {
        $data = [
            'title' => 'Test Event',
            'description' => 'This is a test event',
            'location' => '123 Test Street',
            'latitude' => 10.12345678,
            'longitude' => 106.12345678,
            'start_time' => now()->subDays(1)->toISOString(),
            'end_time' => now()->addDays(1)->toISOString(),
        ];

        $response = $this->postJson('/api/v1/events', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['start_time']);
    }

    public function test_it_shows_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/v1/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $event->id)
            ->assertJsonPath('data.title', $event->title);
    }

    public function test_it_updates_event(): void
    {
        $event = Event::factory()->create();
        $updateData = [
            'title' => 'Updated Event Title',
            'description' => 'Updated description',
        ];

        $response = $this->putJson("/api/v1/events/{$event->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Event Title')
            ->assertJsonPath('data.description', 'Updated description');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event Title',
        ]);
    }

    public function test_it_deletes_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/v1/events/{$event->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    public function test_it_returns_404_for_nonexistent_event(): void
    {
        $response = $this->getJson('/api/v1/events/999');

        $response->assertStatus(404);
    }
}
