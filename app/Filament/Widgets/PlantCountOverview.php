<?php

namespace App\Filament\Widgets;

use App\Models\Plant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlantCountOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $shop = $user?->shop;

        return [
            Stat::make('تعداد گیاهان ثبت شده', Plant::count())
                ->description('تعداد کل گیاهان سایت')
                ->descriptionIcon('heroicon-m-sparkles'),

            Stat::make(
                'تعداد گیاهان فروشگاه من',
                $shop ? Plant::forShop($shop->id)->count() : 0
            )
                ->description('تعداد گیاهان ثبت‌شده در فروشگاه شما')
                ->descriptionIcon('heroicon-m-building-storefront'),
        ];
    }
}