<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CampType;
use App\Models\Page;
use App\Models\Event;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.main', 'layouts.*'], function ($view) {
            $campTypes = CampType::all();
            $campPages = Page::where('location', 'camps')->where('status', 'active')->get();
            $aboutPages = Page::where('location', 'about')->where('status', 'active')->get();
            $resourcesPages = Page::where('location', 'resources')->where('status', 'active')->get();

            // Check for open events ending after today
            $showEvents = Event::where('is_open', true)
                ->where('end_date', '>', Carbon::today())
                ->exists();

            $view->with([
                'campPages' => $campPages,
                'aboutPages' => $aboutPages,
                'resourcesPages' => $resourcesPages,
                'campTypes' => $campTypes,
                'showEvents' => $showEvents,
            ]);

        });
    }
}
