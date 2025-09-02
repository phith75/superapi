<?php

namespace App\Services;

use App\Models\Transport;
use App\Repositories\TransportRepository;
use Illuminate\Database\Eloquent\Collection;

class TransportService
{
    public function __construct(
        protected TransportRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Transport
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Transport
    {
        $transport = $this->repository->find($id);
        
        if (!$transport) {
            return null;
        }

        $this->repository->update($transport, $data);
        
        return $transport->fresh();
    }

    public function delete(int $id): bool
    {
        $transport = $this->repository->find($id);
        
        if (!$transport) {
            return false;
        }

        return $this->repository->delete($transport);
    }

    public function find(int $id): ?Transport
    {
        return $this->repository->find($id);
    }
}
