<?php

namespace App\Services;

use App\Models\Travel;
use App\Repositories\TravelRepository;
use Illuminate\Database\Eloquent\Collection;

class TravelService
{
    public function __construct(
        protected TravelRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Travel
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Travel
    {
        $travel = $this->repository->find($id);
        
        if (!$travel) {
            return null;
        }

        $this->repository->update($travel, $data);
        
        return $travel->fresh();
    }

    public function delete(int $id): bool
    {
        $travel = $this->repository->find($id);
        
        if (!$travel) {
            return false;
        }

        return $this->repository->delete($travel);
    }

    public function find(int $id): ?Travel
    {
        return $this->repository->find($id);
    }
}
