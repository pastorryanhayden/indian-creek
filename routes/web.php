<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampPageController;
use App\Http\Controllers\HomePageController;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/camp-page', [CampPageController::class, 'index'])->name('camp-page');
