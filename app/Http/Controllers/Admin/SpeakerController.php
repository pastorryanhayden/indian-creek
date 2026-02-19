<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpeakerRequest;
use App\Models\CampWeek;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::orderBy('name')->paginate(10);

        return view('admin.speakers.index', compact('speakers'));
    }

    public function create()
    {
        $campWeeks = CampWeek::orderBy('start_date', 'desc')->get();
        $events = Event::orderBy('start_date', 'desc')->get();

        return view('admin.speakers.create', compact('campWeeks', 'events'));
    }

    public function store(SpeakerRequest $request)
    {
        $data = $request->validated();
        $campWeeks = $data['camp_weeks'] ?? [];
        $events = $data['events'] ?? [];
        unset($data['camp_weeks'], $data['events']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('speaker-images', 'public');
        }

        $speaker = Speaker::create($data);
        $speaker->campWeeks()->sync($campWeeks);
        $speaker->events()->sync($events);

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker created successfully.');
    }

    public function edit(Speaker $speaker)
    {
        $campWeeks = CampWeek::orderBy('start_date', 'desc')->get();
        $events = Event::orderBy('start_date', 'desc')->get();
        $speaker->load(['campWeeks', 'events']);

        return view('admin.speakers.edit', compact('speaker', 'campWeeks', 'events'));
    }

    public function update(SpeakerRequest $request, Speaker $speaker)
    {
        $data = $request->validated();
        $campWeeks = $data['camp_weeks'] ?? [];
        $events = $data['events'] ?? [];
        unset($data['camp_weeks'], $data['events']);

        if ($request->hasFile('image')) {
            if ($speaker->image) {
                Storage::disk('public')->delete($speaker->image);
            }
            $data['image'] = $request->file('image')->store('speaker-images', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($speaker->image) {
                Storage::disk('public')->delete($speaker->image);
            }
            $data['image'] = null;
        }

        $speaker->update($data);
        $speaker->campWeeks()->sync($campWeeks);
        $speaker->events()->sync($events);

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker updated successfully.');
    }

    public function destroy(Speaker $speaker)
    {
        if ($speaker->image) {
            Storage::disk('public')->delete($speaker->image);
        }
        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker deleted successfully.');
    }
}
