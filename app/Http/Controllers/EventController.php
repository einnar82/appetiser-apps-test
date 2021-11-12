<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\API\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return EventResource::collection(Event::get());
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
