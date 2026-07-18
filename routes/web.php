<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PageController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [PlantController::class, 'index'])->name('home');
Route::get('/plants/{slug}', [PlantController::class, 'show'])->name('plants.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

