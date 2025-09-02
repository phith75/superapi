<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transport\StoreTransportRequest;
use App\Http\Requests\Transport\UpdateTransportRequest;
use App\Http\Resources\Api\TransportResource;
use App\Services\TransportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransportController extends Controller
{
    public function __construct(
        protected TransportService $transportService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['transport_type', 'latitude', 'longitude', 'radius']);
        
        $transports = $this->transportService->list($filters);
        
        return TransportResource::collection($transports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransportRequest $request): TransportResource
    {
        $transport = $this->transportService->store($request->validated());
        
        return new TransportResource($transport);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): TransportResource
    {
        $transport = $this->transportService->find($id);
        
        if (!$transport) {
            abort(404, 'Transport route not found');
        }
        
        return new TransportResource($transport);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransportRequest $request, int $id): TransportResource
    {
        $transport = $this->transportService->update($id, $request->validated());
        
        if (!$transport) {
            abort(404, 'Transport route not found');
        }
        
        return new TransportResource($transport);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->transportService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Transport route not found');
        }
        
        return response()->json(null, 204);
    }
}
