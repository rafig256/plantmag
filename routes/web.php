<?php

use Illuminate\Support\Facades\Route;
use App\Models\Plant;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Storage;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [PlantController::class, 'index'])->name('home');
Route::get('/plants/{slug}', [PlantController::class, 'show'])->name('plants.show');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/download-qr/{plant}', function (Plant $plant) {
    abort_unless($plant->qr_code_path, 404);

    return Storage::disk('public')->download(
        $plant->qr_code_path,
        'plant-' . $plant->id . '-qr.svg'
    );
})->name('plants.download-qr');

