<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CampWeekRequest;
use App\Models\CampType;
use App\Models\CampWeek;
use App\Models\Speaker;

class CampWeekController extends Controller
{
    public function index()
    {
        $campWeeks = CampWeek::with('type')->orderBy('start_date', 'desc')->paginate(10);

        return view('admin.camp-weeks.index', compact('campWeeks'));
    }

    public function create()
    {
        $campTypes = CampType::orderBy('name')->get();
        $speakers = Speaker::orderBy('name')->get();

        return view('admin.camp-weeks.create', compact('campTypes', 'speakers'));
    }

    public function store(CampWeekRequest $request)
    {
        $data = $request->validated();
        $speakers = $data['speakers'] ?? [];
        unset($data['speakers']);

        $campWeek = CampWeek::create($data);
        $campWeek->speakers()->sync($speakers);

        return redirect()
            ->route('admin.camp-weeks.index')
            ->with('success', 'Camp week created successfully.');
    }

    public function edit(CampWeek $campWeek)
    {
        $campTypes = CampType::orderBy('name')->get();
        $speakers = Speaker::orderBy('name')->get();
        $campWeek->load('speakers');

        return view('admin.camp-weeks.edit', compact('campWeek', 'campTypes', 'speakers'));
    }

    public function update(CampWeekRequest $request, CampWeek $campWeek)
    {
        $data = $request->validated();
        $speakers = $data['speakers'] ?? [];
        unset($data['speakers']);

        $campWeek->update($data);
        $campWeek->speakers()->sync($speakers);

        return redirect()
            ->route('admin.camp-weeks.index')
            ->with('success', 'Camp week updated successfully.');
    }

    public function destroy(CampWeek $campWeek)
    {
        $campWeek->delete();

        return redirect()
            ->route('admin.camp-weeks.index')
            ->with('success', 'Camp week deleted successfully.');
    }
}
