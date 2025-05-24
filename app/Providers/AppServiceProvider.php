<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CampType;
use App\Models\Page;

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
            $campPages = Page::where('location', 'camps')->get();
            $aboutPages = Page::where('location', 'about')->get();
            $resourcesPages = Page::where('location', 'resources')->get();
            $view->with([
                'campPages' => $campPages,
                'aboutPages' => $aboutPages,
                'resourcesPages' => $resourcesPages,
                'campTypes' => $campTypes,
            ]);

        });
    }
}
