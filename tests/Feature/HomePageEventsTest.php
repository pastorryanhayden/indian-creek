<?php

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

function makeEvent(array $overrides = []): Event
{
    return Event::query()->create(array_merge([
        'title' => 'Legacy Camp',
        'slug' => 'legacy-camp-'.fake()->unique()->numerify('###'),
        'description' => 'A seasonal event at camp.',
        'image' => 'events/legacy.jpg',
        'start_date' => Carbon::today()->addMonth(),
        'end_date' => Carbon::today()->addMonth()->addDay(),
        'is_open' => true,
        'is_featured' => false,
        'content' => '<p>Details</p>',
    ], $overrides));
}

it('features open events starting within the next three months on the home page', function () {
    $homeEvent = makeEvent([
        'title' => 'Legacy Camp',
        'slug' => 'legacy-camp',
        'start_date' => Carbon::today()->addWeeks(2),
        'end_date' => Carbon::today()->addWeeks(2)->addDay(),
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee($homeEvent->title);
    $response->assertSee(route('events.show', $homeEvent->slug), false);
});

it('does not feature closed, past, or far-future events on the home page', function () {
    makeEvent([
        'title' => 'Closed Event',
        'slug' => 'closed-event',
        'is_open' => false,
    ]);
    makeEvent([
        'title' => 'Past Event',
        'slug' => 'past-event',
        'start_date' => Carbon::today()->subWeeks(3),
        'end_date' => Carbon::today()->subWeeks(2),
    ]);
    makeEvent([
        'title' => 'Far Future Event',
        'slug' => 'far-future-event',
        'start_date' => Carbon::today()->addMonths(4),
        'end_date' => Carbon::today()->addMonths(4)->addDay(),
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertDontSee('Closed Event');
    $response->assertDontSee('Past Event');
    $response->assertDontSee('Far Future Event');
});

it('hides the home events section when there are no qualifying events', function () {
    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertDontSee('data-home-events', false);
});

it('shows only the two soonest events and a see-all link when more than two qualify', function () {
    makeEvent([
        'title' => 'Soonest Event',
        'slug' => 'soonest-event',
        'start_date' => Carbon::today()->addWeeks(1),
        'end_date' => Carbon::today()->addWeeks(1)->addDay(),
    ]);
    makeEvent([
        'title' => 'Second Event',
        'slug' => 'second-event',
        'start_date' => Carbon::today()->addWeeks(3),
        'end_date' => Carbon::today()->addWeeks(3)->addDay(),
    ]);
    makeEvent([
        'title' => 'Third Event',
        'slug' => 'third-event',
        'start_date' => Carbon::today()->addWeeks(6),
        'end_date' => Carbon::today()->addWeeks(6)->addDay(),
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Soonest Event');
    $response->assertSee('Second Event');
    $response->assertDontSee('Third Event');
    $response->assertSee('See all upcoming events');
    $response->assertSee(route('events.index'), false);
});

it('does not show the see-all link when two or fewer events qualify', function () {
    makeEvent([
        'title' => 'Only Event',
        'slug' => 'only-event',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Only Event');
    $response->assertDontSee('See all upcoming events');
});
