<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EventsPageController;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/camp-page', [CampPageController::class, 'index'])->name('camp-page');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/events', [EventsPageController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventsPageController::class, 'show'])->name('events.show');