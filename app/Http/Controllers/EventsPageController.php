<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class EventsPageController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->where('is_open', true)
            ->where('end_date', '>', Carbon::today())
            ->orderBy('start_date')
            ->get();

        return view('events', compact('events'));
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->with('speakers')
            ->where('slug', $slug)
            ->where('is_open', true)
            ->firstOrFail();

        return view('events-single', compact('event'));
    }
}
