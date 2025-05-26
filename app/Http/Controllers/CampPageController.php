<?php

namespace App\Http\Controllers;

use App\Models\CampType;
use App\Models\CampWeek;
use Illuminate\Http\Request;

class CampPageController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all camp types and weeks
        $types = CampType::all();



        $weeks = CampWeek::with(['speakers', 'type'])
            ->where('status', 'active')
            ->where('is_open', true)
            ->get();

        // Get query parameters
        $queryTypeId = $request->query('type');
        $queryWeekId = $request->query('week');

        // Determine default type ID
        $defaultTypeId = null;
        if ($queryTypeId && $types->contains('id', $queryTypeId)) {
            $defaultTypeId = $queryTypeId;
        } else {
            $featuredType = $types->firstWhere('featured', true);
            if ($featuredType) {
                $defaultTypeId = $featuredType->id;
            } elseif ($types->isNotEmpty()) {
                $defaultTypeId = $types->first()->id;
            }
        }

        // Determine default week ID
        $defaultWeekId = '0'; // Fallback if no valid week is found
        if ($defaultTypeId) {
            $validWeeks = $weeks->where('type_id', $defaultTypeId);
            if ($queryWeekId && $validWeeks->contains('id', $queryWeekId)) {
                $defaultWeekId = $queryWeekId;
            } elseif ($validWeeks->isNotEmpty()) {
                $defaultWeekId = $validWeeks->first()->id;
            }
        }

        // Cast IDs to strings for Alpine.js compatibility
        $defaultTypeId = (string) $defaultTypeId;
        $defaultWeekId = (string) $defaultWeekId;

        return view('camp-page', compact('types', 'weeks', 'defaultTypeId', 'defaultWeekId'));
    }
}
