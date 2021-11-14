<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\API\EventResource;
use App\Models\Event;
use App\Queries\Event\FilterByFrom;
use App\Queries\Event\FilterByName;
use App\Queries\Event\FilterByTo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;

class EventController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): ?AnonymousResourceCollection
    {
        $events = app(Pipeline::class)
            ->send(Event::query())
            ->through([
                FilterByName::class,
                FilterByFrom::class,
                FilterByTo::class
            ])
            ->thenReturn()
            ->simplePaginate();
        return EventResource::collection($events);
    }

    /**
     * @param Event $event
     * @return EventResource
     */
    public function show(Event $event): EventResource
    {
        return new EventResource($event);
    }

    /**
     * @param EventStoreRequest $request
     * @return EventResource
     */
    public function store(EventStoreRequest $request): EventResource
    {
        $event = Event::create($request->validated());
        return new EventResource($event);
    }

    /**
     * @param EventUpdateRequest $request
     * @param Event $event
     * @return EventResource
     */
    public function update(EventUpdateRequest $request, Event $event): EventResource
    {
        $updatedEvent = tap($event)->update($request->validated());
        return new EventResource($updatedEvent);
    }
}
