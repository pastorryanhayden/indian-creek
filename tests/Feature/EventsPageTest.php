<?php

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

function createEvent(array $overrides = []): Event
{
    return Event::query()->create(array_merge([
        'title' => 'Young Preachers Summit',
        'slug' => 'young-preachers-summit',
        'description' => 'A weekend for young preachers.',
        'image' => 'events/summit.jpg',
        'start_date' => Carbon::today()->addDays(10),
        'end_date' => Carbon::today()->addDays(12),
        'is_open' => true,
        'is_featured' => false,
        'content' => '<p>Join us for an encouraging weekend.</p>',
    ], $overrides));
}

it('lists open upcoming events on the events page', function () {
    $upcoming = createEvent();
    createEvent([
        'title' => 'Past Retreat',
        'slug' => 'past-retreat',
        'start_date' => Carbon::today()->subDays(10),
        'end_date' => Carbon::today()->subDays(8),
    ]);
    createEvent([
        'title' => 'Closed Event',
        'slug' => 'closed-event',
        'is_open' => false,
    ]);

    $response = $this->get(route('events.index'));

    $response->assertSuccessful();
    $response->assertSee('Other Events');
    $response->assertSee($upcoming->title);
    $response->assertDontSee('Past Retreat');
    $response->assertDontSee('Closed Event');
});

it('shows an empty state when there are no upcoming events', function () {
    $response = $this->get(route('events.index'));

    $response->assertSuccessful();
    $response->assertSee('No upcoming events');
});

it('shows a single open event by slug', function () {
    $event = createEvent();

    $response = $this->get(route('events.show', $event->slug));

    $response->assertSuccessful();
    $response->assertSee($event->title);
    $response->assertSee('Join us for an encouraging weekend.');
});

it('returns not found for a closed or missing event', function () {
    createEvent([
        'slug' => 'closed-event',
        'is_open' => false,
    ]);

    $this->get(route('events.show', 'closed-event'))->assertNotFound();
    $this->get(route('events.show', 'does-not-exist'))->assertNotFound();
});
