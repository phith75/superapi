<?php

namespace App\Services;

use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\Collection;

class RecipeService
{
    public function __construct(
        protected RecipeRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Recipe
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Recipe
    {
        $recipe = $this->repository->find($id);
        
        if (!$recipe) {
            return null;
        }

        $this->repository->update($recipe, $data);
        
        return $recipe->fresh();
    }

    public function delete(int $id): bool
    {
        $recipe = $this->repository->find($id);
        
        if (!$recipe) {
            return false;
        }

        return $this->repository->delete($recipe);
    }

    public function find(int $id): ?Recipe
    {
        return $this->repository->find($id);
    }
}
