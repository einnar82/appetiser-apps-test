<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIfCanReturnAllEvents()
    {
        $event = Event::factory(5)->create();

        $response = $this->getJson('api/events');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'from',
                        'to',
                        'days',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);

        $this->assertCount(5, $event->all());
    }

    public function testIfCanReturnAnEvent()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'from',
                    'to',
                    'days',
                    'created_at',
                    'updated_at'
                ]
            ]);
        $this->assertCount(1, $event->all());
    }

    public function testIfCanValidateAddEvents()
    {
        $response = $this->postJson('api/events');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'title',
                    'from',
                    'to'
                ]
            ]);
    }


    public function testIfCanCreateAnEvent()
    {
        $title = $this->faker->sentence(4);
        $from = $this->faker->date();
        $to = $this->faker->date();

        $response = $this->post(route('events.store'), [
            'title' => $title,
            'from' => $from,
            'to' => $to,
        ]);

        $events = Event::query()
            ->where('title', $title)
            ->where('from', $from)
            ->where('to', $to)
            ->get();
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'from',
                    'to',
                    'created_at',
                    'updated_at'
                ]
            ]);
        $this->assertCount(1, $events);
    }



    public function testIfReturnMethodNotAllowedException()
    {
        $response = $this->putJson('/api/events');
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED)
            ->assertJsonStructure([
                'message',
                'exception',
                'file',
                'line',
                'trace'
            ]);
    }


    public function testIfCanUpdateAnEvent()
    {
        $event = Event::factory()->create();
        $title = $this->faker->sentence(4);
        $from = $this->faker->date();
        $to = $this->faker->date();

        $response = $this->put(route('events.update', $event), [
            'title' => $title,
            'from' => $from,
            'to' => $to,
        ]);

        $events = Event::query()
            ->where('title', $title)
            ->where('from', $from)
            ->where('to', $to)
            ->get();

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'from',
                    'to',
                    'created_at',
                    'updated_at'
                ]
            ]);
        $this->assertCount(1, $events);
    }
}
