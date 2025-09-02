<?php

namespace Tests\Feature\Api\V1;

use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_quizzes(): void
    {
        Quiz::factory(3)->create();

        $response = $this->getJson('/api/v1/quizzes');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'difficulty_level',
                        'time_limit',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_quizzes_by_difficulty(): void
    {
        Quiz::factory()->easy()->create();
        Quiz::factory()->hard()->create();

        $response = $this->getJson('/api/v1/quizzes?difficulty_level=easy');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_filters_active_quizzes(): void
    {
        Quiz::factory()->create(['is_active' => true]);
        Quiz::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/v1/quizzes?active=1');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_creates_quiz_with_valid_payload(): void
    {
        $data = [
            'title' => 'Test Quiz',
            'description' => 'This is a test quiz',
            'difficulty_level' => 'medium',
            'time_limit' => 30,
            'is_active' => true,
        ];

        $response = $this->postJson('/api/v1/quizzes', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Test Quiz')
            ->assertJsonPath('data.difficulty_level', 'medium');

        $this->assertDatabaseHas('quizzes', [
            'title' => 'Test Quiz',
            'difficulty_level' => 'medium',
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/quizzes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description', 'difficulty_level', 'time_limit']);
    }

    public function test_it_validates_difficulty_level(): void
    {
        $data = [
            'title' => 'Test Quiz',
            'description' => 'This is a test quiz',
            'difficulty_level' => 'invalid_level',
            'time_limit' => 30,
        ];

        $response = $this->postJson('/api/v1/quizzes', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['difficulty_level']);
    }

    public function test_it_validates_time_limit_range(): void
    {
        $data = [
            'title' => 'Test Quiz',
            'description' => 'This is a test quiz',
            'difficulty_level' => 'medium',
            'time_limit' => 0,
        ];

        $response = $this->postJson('/api/v1/quizzes', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_limit']);
    }

    public function test_it_shows_quiz(): void
    {
        $quiz = Quiz::factory()->create();

        $response = $this->getJson("/api/v1/quizzes/{$quiz->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $quiz->id)
            ->assertJsonPath('data.title', $quiz->title);
    }

    public function test_it_updates_quiz(): void
    {
        $quiz = Quiz::factory()->create();
        $updateData = [
            'title' => 'Updated Quiz Title',
            'difficulty_level' => 'hard',
        ];

        $response = $this->putJson("/api/v1/quizzes/{$quiz->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Quiz Title')
            ->assertJsonPath('data.difficulty_level', 'hard');

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'title' => 'Updated Quiz Title',
        ]);
    }

    public function test_it_deletes_quiz(): void
    {
        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson("/api/v1/quizzes/{$quiz->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('quizzes', ['id' => $quiz->id]);
    }

    public function test_it_returns_404_for_nonexistent_quiz(): void
    {
        $response = $this->getJson('/api/v1/quizzes/999');

        $response->assertStatus(404);
    }
}
