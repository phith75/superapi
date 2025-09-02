<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Collection;

class EventService
{
    public function __construct(
        protected EventRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Event
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Event
    {
        $event = $this->repository->find($id);
        
        if (!$event) {
            return null;
        }

        $this->repository->update($event, $data);
        
        return $event->fresh();
    }

    public function delete(int $id): bool
    {
        $event = $this->repository->find($id);
        
        if (!$event) {
            return false;
        }

        return $this->repository->delete($event);
    }

    public function find(int $id): ?Event
    {
        return $this->repository->find($id);
    }
}
