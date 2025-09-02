<?php

namespace App\Repositories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Collection;

class TransportRepository
{
    public function __construct(
        protected Transport $model
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['transport_type'])) {
            $query->filterByType($filters['transport_type']);
        }

        if (isset($filters['latitude']) && isset($filters['longitude'])) {
            $radius = $filters['radius'] ?? 5.0;
            $query->nearby($filters['latitude'], $filters['longitude'], $radius);
        }

        return $query->latest()->get();
    }

    public function find(int $id): ?Transport
    {
        return $this->model->find($id);
    }

    public function create(array $data): Transport
    {
        return $this->model->create($data);
    }

    public function update(Transport $transport, array $data): bool
    {
        return $transport->update($data);
    }

    public function delete(Transport $transport): bool
    {
        return $transport->delete();
    }
}
