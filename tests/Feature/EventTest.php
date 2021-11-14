<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIfCanReturnAllEvents()
    {
        Event::factory(5)->create();

        $response = $this->getJson('api/events');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testIfCanReturnAnEvent()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testIfCanValidateAddEvents()
    {
        $response = $this->postJson('api/events');
        $response->assertStatus(422);
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
        $response->assertStatus(201);
        $this->assertCount(1, $events);
    }



    public function testIfCanValidateUpdateEvent()
    {
        $response = $this->putJson('/api/events');
        $response->assertStatus(405);
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

        $response->assertStatus(200);
        $this->assertCount(1, $events);
    }
}