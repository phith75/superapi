<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\Api\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['upcoming', 'past']);
        
        $events = $this->eventService->list($filters);
        
        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): EventResource
    {
        $event = $this->eventService->store($request->validated());
        
        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): EventResource
    {
        $event = $this->eventService->find($id);
        
        if (!$event) {
            abort(404, 'Event not found');
        }
        
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, int $id): EventResource
    {
        $event = $this->eventService->update($id, $request->validated());
        
        if (!$event) {
            abort(404, 'Event not found');
        }
        
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->eventService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Event not found');
        }
        
        return response()->json(null, 204);
    }
}
