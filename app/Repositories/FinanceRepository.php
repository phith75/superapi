<?php

namespace App\Repositories;

use App\Models\Finance;
use Illuminate\Database\Eloquent\Collection;

class FinanceRepository
{
    public function __construct(
        protected Finance $model
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (isset($filters['recent']) && $filters['recent']) {
            $hours = $filters['hours'] ?? 24;
            $query->recentlyUpdated($hours);
        }

        return $query->latest('last_updated')->get();
    }

    public function find(int $id): ?Finance
    {
        return $this->model->find($id);
    }

    public function create(array $data): Finance
    {
        return $this->model->create($data);
    }

    public function update(Finance $finance, array $data): bool
    {
        return $finance->update($data);
    }

    public function delete(Finance $finance): bool
    {
        return $finance->delete();
    }

    public function updatePrices(array $prices): void
    {
        foreach ($prices as $price) {
            $finance = $this->model->where('type', $price['type'])
                ->where('name', $price['name'])
                ->first();

            if ($finance) {
                $previousPrice = $finance->current_price;
                $currentPrice = $price['current_price'];
                $changePercentage = (($currentPrice - $previousPrice) / $previousPrice) * 100;

                $finance->update([
                    'previous_price' => $previousPrice,
                    'current_price' => $currentPrice,
                    'change_percentage' => round($changePercentage, 2),
                    'last_updated' => now(),
                ]);
            }
        }
    }
}
