<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [PlantController::class, 'index'])->name('home');
Route::get('/plants/{slug}', [PlantController::class, 'show'])->name('plants.show');
