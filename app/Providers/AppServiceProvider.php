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
        Carbon::setLocale(config('app.locale'));
        FilamentAsset::register([
            Css::make('sahel-font', asset('css/filament-theme.css')),
        ]);
        View::composer('*', function ($view) {
            $settings = Setting::getCached(null);
            $view->with('settings', $settings);
        });
    }
}
