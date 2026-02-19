<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampPage as CampPageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampPageController extends Controller
{
    public function edit()
    {
        $campPage = CampPageModel::firstOrCreate([
            'id' => 1,
        ]);

        return view('admin.camp-page.edit', compact('campPage'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Hero Section
            'hero_season' => 'nullable|string|max:255',
            'hero_helper_text' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_video' => 'nullable|file|mimes:mp4,webm|max:10240',
            'hero_poster' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            // Step 3
            'step_3_title' => 'nullable|string|max:255',
            'step_3_content' => 'nullable|string',
            'step_3_faq' => 'nullable|array',
            'step_3_faq.*.question' => 'required_with:step_3_faq|string',
            'step_3_faq.*.answer' => 'required_with:step_3_faq|string',
            'step_3_info_text' => 'nullable|array',
            'step_3_info_text.*.paragraph' => 'required_with:step_3_info_text|string',
            'step_3_address' => 'nullable|string',
            'step_3_download' => 'nullable|file|mimes:pdf|max:5120',
            'step_3_download_content' => 'nullable|string|max:255',

            // Step 4
            'step_4_title' => 'nullable|string|max:255',
            'step_4_content' => 'nullable|string',
            'step_4_info_text' => 'nullable|string',
            'step_4_faq' => 'nullable|array',
            'step_4_faq.*.question' => 'required_with:step_4_faq|string',
            'step_4_faq.*.answer' => 'required_with:step_4_faq|string',
            'step_4_download' => 'nullable|file|mimes:pdf|max:5120',
            'step_4_download_content' => 'nullable|string|max:255',

            // Step 5
            'step_5_title' => 'nullable|string|max:255',
            'step_5_sections' => 'nullable|array',
            'step_5_sections.*.title' => 'required_with:step_5_sections|string',
            'step_5_sections.*.content' => 'required_with:step_5_sections|string',
            'step_5_sections.*.link_url' => 'nullable|url',
            'step_5_sections.*.link_text' => 'nullable|string',
            'step_5_background_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $campPage = CampPageModel::firstOrNew(['id' => 1]);

        // Handle file uploads
        if ($request->hasFile('hero_video')) {
            if ($campPage->hero_video) {
                Storage::disk('public')->delete($campPage->hero_video);
            }
            $validated['hero_video'] = $request->file('hero_video')->store('videos', 'public');
        } elseif ($request->boolean('remove_hero_video')) {
            if ($campPage->hero_video) {
                Storage::disk('public')->delete($campPage->hero_video);
            }
            $validated['hero_video'] = null;
        } else {
            unset($validated['hero_video']);
        }

        if ($request->hasFile('hero_poster')) {
            if ($campPage->hero_poster) {
                Storage::disk('public')->delete($campPage->hero_poster);
            }
            $validated['hero_poster'] = $request->file('hero_poster')->store('images', 'public');
        } elseif ($request->boolean('remove_hero_poster')) {
            if ($campPage->hero_poster) {
                Storage::disk('public')->delete($campPage->hero_poster);
            }
            $validated['hero_poster'] = null;
        } else {
            unset($validated['hero_poster']);
        }

        if ($request->hasFile('step_3_download')) {
            if ($campPage->step_3_download) {
                Storage::disk('public')->delete($campPage->step_3_download);
            }
            $validated['step_3_download'] = $request->file('step_3_download')->store('downloads', 'public');
        } elseif ($request->boolean('remove_step_3_download')) {
            if ($campPage->step_3_download) {
                Storage::disk('public')->delete($campPage->step_3_download);
            }
            $validated['step_3_download'] = null;
        } else {
            unset($validated['step_3_download']);
        }

        if ($request->hasFile('step_4_download')) {
            if ($campPage->step_4_download) {
                Storage::disk('public')->delete($campPage->step_4_download);
            }
            $validated['step_4_download'] = $request->file('step_4_download')->store('downloads', 'public');
        } elseif ($request->boolean('remove_step_4_download')) {
            if ($campPage->step_4_download) {
                Storage::disk('public')->delete($campPage->step_4_download);
            }
            $validated['step_4_download'] = null;
        } else {
            unset($validated['step_4_download']);
        }

        if ($request->hasFile('step_5_background_image')) {
            if ($campPage->step_5_background_image) {
                Storage::disk('public')->delete($campPage->step_5_background_image);
            }
            $validated['step_5_background_image'] = $request->file('step_5_background_image')->store('images', 'public');
        } elseif ($request->boolean('remove_step_5_background_image')) {
            if ($campPage->step_5_background_image) {
                Storage::disk('public')->delete($campPage->step_5_background_image);
            }
            $validated['step_5_background_image'] = null;
        } else {
            unset($validated['step_5_background_image']);
        }

        $campPage->fill($validated);
        $campPage->save();

        return redirect()->route('admin.camp-page.edit')->with('success', 'Camp page updated successfully.');
    }
}
