<?php

namespace App\Repositories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Collection;

class TravelRepository
{
    public function __construct(
        protected Travel $model
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['category'])) {
            $query->filterByCategory($filters['category']);
        }

        return $query->latest()->get();
    }

    public function find(int $id): ?Travel
    {
        return $this->model->find($id);
    }

    public function create(array $data): Travel
    {
        return $this->model->create($data);
    }

    public function update(Travel $travel, array $data): bool
    {
        return $travel->update($data);
    }

    public function delete(Travel $travel): bool
    {
        return $travel->delete();
    }
}
