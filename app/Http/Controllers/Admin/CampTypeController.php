<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CampTypeRequest;
use App\Models\CampType;
use Illuminate\Support\Facades\Storage;

class CampTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campTypes = CampType::orderBy('name')->paginate(10);

        return view('admin.camp-types.index', compact('campTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.camp-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampTypeRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('camp-types', 'public');
        }

        CampType::create($data);

        return redirect()
            ->route('admin.camp-types.index')
            ->with('success', 'Camp type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampType $campType)
    {
        return view('admin.camp-types.edit', compact('campType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CampTypeRequest $request, CampType $campType)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($campType->image) {
                Storage::disk('public')->delete($campType->image);
            }
            $data['image'] = $request->file('image')->store('camp-types', 'public');
        } elseif ($request->boolean('remove_image')) {
            // Remove image if requested
            if ($campType->image) {
                Storage::disk('public')->delete($campType->image);
            }
            $data['image'] = null;
        }

        $campType->update($data);

        return redirect()
            ->route('admin.camp-types.index')
            ->with('success', 'Camp type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampType $campType)
    {
        // Delete associated image
        if ($campType->image) {
            Storage::disk('public')->delete($campType->image);
        }

        $campType->delete();

        return redirect()
            ->route('admin.camp-types.index')
            ->with('success', 'Camp type deleted successfully.');
    }
}
