<?php

namespace Tests\Feature\Api\V1;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_recipes(): void
    {
        Recipe::factory(3)->create();

        $response = $this->getJson('/api/v1/recipes');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'calories',
                        'image_url',
                        'ingredients',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_it_filters_recipes_by_max_calories(): void
    {
        Recipe::factory()->lowCalorie()->create();
        Recipe::factory()->highCalorie()->create();

        $response = $this->getJson('/api/v1/recipes?max_calories=300');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_creates_recipe_with_valid_payload(): void
    {
        $data = [
            'title' => 'Test Recipe',
            'description' => 'This is a test recipe',
            'calories' => 250,
            'image_url' => 'https://example.com/image.jpg',
        ];

        $response = $this->postJson('/api/v1/recipes', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Test Recipe')
            ->assertJsonPath('data.calories', 250);

        $this->assertDatabaseHas('recipes', [
            'title' => 'Test Recipe',
            'calories' => 250,
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/recipes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description', 'calories']);
    }

    public function test_it_validates_calories_range(): void
    {
        $data = [
            'title' => 'Test Recipe',
            'description' => 'This is a test recipe',
            'calories' => 0,
        ];

        $response = $this->postJson('/api/v1/recipes', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['calories']);
    }

    public function test_it_shows_recipe(): void
    {
        $recipe = Recipe::factory()->create();

        $response = $this->getJson("/api/v1/recipes/{$recipe->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $recipe->id)
            ->assertJsonPath('data.title', $recipe->title);
    }

    public function test_it_updates_recipe(): void
    {
        $recipe = Recipe::factory()->create();
        $updateData = [
            'title' => 'Updated Recipe Title',
            'calories' => 300,
        ];

        $response = $this->putJson("/api/v1/recipes/{$recipe->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Recipe Title')
            ->assertJsonPath('data.calories', 300);

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'title' => 'Updated Recipe Title',
        ]);
    }

    public function test_it_deletes_recipe(): void
    {
        $recipe = Recipe::factory()->create();

        $response = $this->deleteJson("/api/v1/recipes/{$recipe->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('recipes', ['id' => $recipe->id]);
    }

    public function test_it_returns_404_for_nonexistent_recipe(): void
    {
        $response = $this->getJson('/api/v1/recipes/999');

        $response->assertStatus(404);
    }
}
