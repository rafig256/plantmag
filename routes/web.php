<?php

use Illuminate\Support\Facades\Route;
use App\Models\Plant;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ShopRequestController;



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
Route::get('/register-shop', [ShopRequestController::class, 'create'])->name('shop.request.create');
Route::post('/register-shop', [ShopRequestController::class, 'store'])->name('shop.request.store');
Route::get('/register-shop/success', [ShopRequestController::class, 'success'])->name('shop.request.success');

// shop
use App\Http\Controllers\ShopController;

// صفحه اصلی فروشگاه (لیست گیاهان)
Route::get('/gol/{shop_slug}', [ShopController::class, 'index'])->name('shop.index');
// صفحه درباره ما فروشگاه
Route::get('/gol/{shop_slug}/about', [ShopController::class, 'about'])->name('shop.about');
// صفحه لیست همه فروشگاه‌ها
Route::get('/shops', [ShopController::class, 'indexAll'])->name('shops.index');




