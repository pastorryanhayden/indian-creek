<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $speakers = Speaker::orderBy('name')->get();

        return view('admin.events.create', compact('speakers'));
    }

    public function store(EventRequest $request)
    {
        $data = $request->validated();
        $speakers = $data['speakers'] ?? [];
        unset($data['speakers']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($data);
        $event->speakers()->sync($speakers);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $speakers = Speaker::orderBy('name')->get();
        $event->load('speakers');

        return view('admin.events.edit', compact('event', 'speakers'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $data = $request->validated();
        $speakers = $data['speakers'] ?? [];
        unset($data['speakers']);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = null;
        }

        $event->update($data);
        $event->speakers()->sync($speakers);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
