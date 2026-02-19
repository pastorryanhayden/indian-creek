<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampType;
use App\Models\CampWeek;
use App\Models\Event;
use App\Models\Page;
use App\Models\Speaker;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'camp_types' => CampType::count(),
            'camp_weeks' => CampWeek::count(),
            'speakers' => Speaker::count(),
            'events' => Event::count(),
            'pages' => Page::count(),
            'users' => User::count(),
        ];

        $recentCampWeeks = CampWeek::with('type')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('is_open', true)
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCampWeeks', 'upcomingEvents'));
    }
}
