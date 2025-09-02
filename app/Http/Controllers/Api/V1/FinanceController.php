<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreFinanceRequest;
use App\Http\Requests\Finance\UpdateFinanceRequest;
use App\Http\Resources\Api\FinanceResource;
use App\Services\FinanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FinanceController extends Controller
{
    public function __construct(
        protected FinanceService $financeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['type', 'recent', 'hours']);
        
        $financeRecords = $this->financeService->list($filters);
        
        return FinanceResource::collection($financeRecords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinanceRequest $request): FinanceResource
    {
        $finance = $this->financeService->store($request->validated());
        
        return new FinanceResource($finance);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): FinanceResource
    {
        $finance = $this->financeService->find($id);
        
        if (!$finance) {
            abort(404, 'Finance record not found');
        }
        
        return new FinanceResource($finance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinanceRequest $request, int $id): FinanceResource
    {
        $finance = $this->financeService->update($id, $request->validated());
        
        if (!$finance) {
            abort(404, 'Finance record not found');
        }
        
        return new FinanceResource($finance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->financeService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Finance record not found');
        }
        
        return response()->json(null, 204);
    }

    /**
     * Get gold prices.
     */
    public function goldPrices(): AnonymousResourceCollection
    {
        $goldPrices = $this->financeService->getGoldPrices();
        
        return FinanceResource::collection($goldPrices);
    }

    /**
     * Get currency exchange rates.
     */
    public function currencyRates(): AnonymousResourceCollection
    {
        $currencyRates = $this->financeService->getCurrencyRates();
        
        return FinanceResource::collection($currencyRates);
    }

    /**
     * Get fuel prices.
     */
    public function fuelPrices(): AnonymousResourceCollection
    {
        $fuelPrices = $this->financeService->getFuelPrices();
        
        return FinanceResource::collection($fuelPrices);
    }
}
