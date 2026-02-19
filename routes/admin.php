<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CampPageController;
use App\Http\Controllers\Admin\CampTypeController;
use App\Http\Controllers\Admin\CampWeekController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are for the custom CMS admin panel. All routes require
| authentication and the 'admin' role.
|
| Note: These routes are already prefixed with 'admin.' in bootstrap/app.php
|
*/

// Guest routes (login only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Protected admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Camp Types
    Route::resource('camp-types', CampTypeController::class)->names([
        'index' => 'camp-types.index',
        'create' => 'camp-types.create',
        'store' => 'camp-types.store',
        'edit' => 'camp-types.edit',
        'update' => 'camp-types.update',
        'destroy' => 'camp-types.destroy',
    ]);

    // Camp Weeks
    Route::resource('camp-weeks', CampWeekController::class)->names([
        'index' => 'camp-weeks.index',
        'create' => 'camp-weeks.create',
        'store' => 'camp-weeks.store',
        'edit' => 'camp-weeks.edit',
        'update' => 'camp-weeks.update',
        'destroy' => 'camp-weeks.destroy',
    ]);

    // Speakers
    Route::resource('speakers', SpeakerController::class)->names([
        'index' => 'speakers.index',
        'create' => 'speakers.create',
        'store' => 'speakers.store',
        'edit' => 'speakers.edit',
        'update' => 'speakers.update',
        'destroy' => 'speakers.destroy',
    ]);

    // Events
    Route::resource('events', EventController::class)->names([
        'index' => 'events.index',
        'create' => 'events.create',
        'store' => 'events.store',
        'edit' => 'events.edit',
        'update' => 'events.update',
        'destroy' => 'events.destroy',
    ]);

    // Pages
    Route::resource('pages', PageController::class)->names([
        'index' => 'pages.index',
        'create' => 'pages.create',
        'store' => 'pages.store',
        'edit' => 'pages.edit',
        'update' => 'pages.update',
        'destroy' => 'pages.destroy',
    ]);

    // CMS Pages (single-page editors)
    Route::get('/home-page', [HomePageController::class, 'edit'])->name('home-page.edit');
    Route::put('/home-page', [HomePageController::class, 'update'])->name('home-page.update');

    Route::get('/camp-page', [CampPageController::class, 'edit'])->name('camp-page.edit');
    Route::put('/camp-page', [CampPageController::class, 'update'])->name('camp-page.update');

    // Users
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
});

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
