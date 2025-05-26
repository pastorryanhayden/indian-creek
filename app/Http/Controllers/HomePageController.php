<?php

namespace App\Http\Controllers;

use App\Models\CampType;
use App\Models\CampWeek;
use App\Models\Page;


class HomePageController extends Controller
{
    public function index()
    {
        $types = CampType::all();

        $featured_page = Page::where('featured', true)->first();

        $weeks = CampWeek::with(['speakers', 'type'])
            ->where('status', 'active')
            ->where('is_open', true)
            ->get();
        return view('home', compact('types', 'weeks', 'featured_page'));
    }
}
