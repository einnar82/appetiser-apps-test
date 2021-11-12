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

    public function test_if_can_return_all_events()
    {
        Event::factory(5)->create();

        $response = $this->getJson('api/events');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_if_can_return_an_event()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_if_can_validate_add_events()
    {
        $response = $this->postJson('api/events');
        $response->assertStatus(422);
    }


    public function test_if_can_create_an_event()
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



    public function test_if_can_validate_update_event()
    {
        $response = $this->putJson('/api/events');
        $response->assertStatus(405);
    }


    public function test_if_can_update_an_event()
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
