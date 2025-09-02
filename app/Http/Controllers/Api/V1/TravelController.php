<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Travel\StoreTravelRequest;
use App\Http\Requests\Travel\UpdateTravelRequest;
use App\Http\Resources\Api\TravelResource;
use App\Services\TravelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TravelController extends Controller
{
    public function __construct(
        protected TravelService $travelService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['category']);
        
        $travels = $this->travelService->list($filters);
        
        return TravelResource::collection($travels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelRequest $request): TravelResource
    {
        $travel = $this->travelService->store($request->validated());
        
        return new TravelResource($travel);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): TravelResource
    {
        $travel = $this->travelService->find($id);
        
        if (!$travel) {
            abort(404, 'Travel not found');
        }
        
        return new TravelResource($travel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTravelRequest $request, int $id): TravelResource
    {
        $travel = $this->travelService->update($id, $request->validated());
        
        if (!$travel) {
            abort(404, 'Travel not found');
        }
        
        return new TravelResource($travel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->travelService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Travel not found');
        }
        
        return response()->json(null, 204);
    }
}
