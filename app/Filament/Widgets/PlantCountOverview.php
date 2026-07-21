<?php

namespace App\Filament\Widgets;

use App\Models\Plant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlantCountOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('تعداد گیاهان ثبت شده', Plant::count())
                ->description('گیاه موجود در پایگاه داده')
                ->descriptionIcon('heroicon-m-sparkles'),
        ];
    }
}