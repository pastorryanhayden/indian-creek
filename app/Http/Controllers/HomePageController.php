<?php

namespace App\Http\Controllers;

use App\Models\CampType;
use App\Models\CampWeek;
use App\Models\Event;
use App\Models\HomePage;
use App\Models\Page;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function index(): View
    {
        $types = CampType::all();

        $featured_page = Page::where('featured', true)->first();

        $weeks = CampWeek::with(['speakers', 'type'])
            ->where('status', '!=', 'hidden')
            ->orderBy('start_date')
            ->get();

        $homePage = HomePage::first();

        $homeEventsQuery = Event::query()->forHomePage();
        $homeEventsTotal = (clone $homeEventsQuery)->count();
        $homeEvents = $homeEventsQuery->limit(2)->get();
        $showAllEventsLink = $homeEventsTotal > 2;

        return view('home', compact(
            'types',
            'weeks',
            'featured_page',
            'homePage',
            'homeEvents',
            'showAllEventsLink',
        ));
    }
}
