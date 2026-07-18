<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تنظیم locale برای Carbon (تاریخ فارسی)
        Carbon::setLocale(config('app.locale'));

        // ثبت Assetهای فیلامنت (فونت سفارشی)
        FilamentAsset::register([
            Css::make('sahel-font', asset('css/filament-theme.css')),
        ]);

        // ارسال تنظیمات به تمام ویوها (با مدیریت خطا)
        View::composer('*', function ($view) {
            try {
                // خواندن تنظیمات از دیتابیس با کش
                $settings = Setting::getCached(null);
                $view->with('settings', $settings);
            } catch (\Exception $e) {
                // اگر جدول settings وجود نداشت، یک آرایه خالی ارسال کن
                $view->with('settings', []);
            }
        });
    }
}