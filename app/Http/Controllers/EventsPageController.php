<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsPageController extends Controller
{
    public function index()
    {
        $events = Event::where('is_open', true)
                ->where('end_date', '>', Carbon::today())
                ->get();

        return view('events', compact('events'));
    }

     public function show($slug, Request $request)
    {
        $event = Event::where('slug', $slug)
            ->where('is_open', true)
            ->firstOrFail();

        return view('events-single', compact('event'));
    }
}
