<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PageController;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/camp-page', [CampPageController::class, 'index'])->name('camp-page');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
