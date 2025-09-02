<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;

class RecipeRepository
{
    public function __construct(
        protected Recipe $model
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['max_calories'])) {
            $query->filterByCalories($filters['max_calories']);
        }

        return $query->with('ingredients')->latest()->get();
    }

    public function find(int $id): ?Recipe
    {
        return $this->model->with('ingredients')->find($id);
    }

    public function create(array $data): Recipe
    {
        return $this->model->create($data);
    }

    public function update(Recipe $recipe, array $data): bool
    {
        return $recipe->update($data);
    }

    public function delete(Recipe $recipe): bool
    {
        return $recipe->delete();
    }
}
