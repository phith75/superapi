<?php

namespace App\Repositories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

class QuizRepository
{
    public function __construct(
        protected Quiz $model
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['difficulty_level'])) {
            $query->byDifficulty($filters['difficulty_level']);
        }

        if (isset($filters['active']) && $filters['active']) {
            $query->active();
        }

        return $query->with(['questions.options'])->latest()->get();
    }

    public function find(int $id): ?Quiz
    {
        return $this->model->with(['questions.options'])->find($id);
    }

    public function create(array $data): Quiz
    {
        return $this->model->create($data);
    }

    public function update(Quiz $quiz, array $data): bool
    {
        return $quiz->update($data);
    }

    public function delete(Quiz $quiz): bool
    {
        return $quiz->delete();
    }
}
