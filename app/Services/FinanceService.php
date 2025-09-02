<?php

namespace App\Services;

use App\Models\Finance;
use App\Repositories\FinanceRepository;
use Illuminate\Database\Eloquent\Collection;

class FinanceService
{
    public function __construct(
        protected FinanceRepository $repository
    ) {}

    public function list(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    public function store(array $data): Finance
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Finance
    {
        $finance = $this->repository->find($id);
        
        if (!$finance) {
            return null;
        }

        $this->repository->update($finance, $data);
        
        return $finance->fresh();
    }

    public function delete(int $id): bool
    {
        $finance = $this->repository->find($id);
        
        if (!$finance) {
            return false;
        }

        return $this->repository->delete($finance);
    }

    public function find(int $id): ?Finance
    {
        return $this->repository->find($id);
    }

    public function syncPrices(array $prices): void
    {
        $this->repository->updatePrices($prices);
    }

    public function getGoldPrices(): Collection
    {
        return $this->repository->getAll(['type' => 'gold']);
    }

    public function getCurrencyRates(): Collection
    {
        return $this->repository->getAll(['type' => 'currency']);
    }

    public function getFuelPrices(): Collection
    {
        return $this->repository->getAll(['type' => 'fuel']);
    }
}
