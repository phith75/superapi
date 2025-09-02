<?php

namespace App\Services;

use App\Models\Quiz;
use App\Repositories\QuizRepository;
use Illuminate\Database\Eloquent\Collection;

class QuizService
{
    public function __construct(
        protected QuizRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Quiz
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Quiz
    {
        $quiz = $this->repository->find($id);
        
        if (!$quiz) {
            return null;
        }

        $this->repository->update($quiz, $data);
        
        return $quiz->fresh();
    }

    public function delete(int $id): bool
    {
        $quiz = $this->repository->find($id);
        
        if (!$quiz) {
            return false;
        }

        return $this->repository->delete($quiz);
    }

    public function find(int $id): ?Quiz
    {
        return $this->repository->find($id);
    }
}
