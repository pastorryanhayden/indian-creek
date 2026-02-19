<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage as HomePageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageController extends Controller
{
    public function edit()
    {
        $homePage = HomePageModel::firstOrCreate([
            'id' => 1,
        ], [
            'main_title' => 'Made for More',
            'main_subtitle' => 'Indian Creek 2025',
            'main_video' => 'https://www.youtube.com/embed/jYEsgNVv23Y?si=qjsEzRyVW7qWDOTV',
            'show_video' => true,
            'show_directions_section' => true,
        ]);

        return view('admin.home-page.edit', compact('homePage'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'main_title' => 'required|string|max:255',
            'main_subtitle' => 'nullable|string|max:255',
            'main_video' => 'nullable|url|max:255',
            'show_video' => 'boolean',
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_url' => 'nullable|string|max:255',
            'show_directions_section' => 'boolean',
            'map_title' => 'nullable|string|max:255',
            'map_highlight' => 'nullable|string|max:255',
            'map_description' => 'nullable|string',
            'map_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'map_link' => 'nullable|url|max:255',
            'map_distances' => 'nullable|array',
            'map_distances.*.city' => 'required_with:map_distances|string|max:255',
            'map_distances.*.distance' => 'required_with:map_distances|string|max:255',
        ]);

        $homePage = HomePageModel::firstOrNew(['id' => 1]);

        // Handle image upload
        if ($request->hasFile('map_image')) {
            if ($homePage->map_image) {
                Storage::disk('public')->delete($homePage->map_image);
            }
            $validated['map_image'] = $request->file('map_image')->store('images', 'public');
        } elseif ($request->boolean('remove_map_image')) {
            if ($homePage->map_image) {
                Storage::disk('public')->delete($homePage->map_image);
            }
            $validated['map_image'] = null;
        } else {
            unset($validated['map_image']);
        }

        $homePage->fill($validated);
        $homePage->save();

        return redirect()->route('admin.home-page.edit')->with('success', 'Home page updated successfully.');
    }
}
