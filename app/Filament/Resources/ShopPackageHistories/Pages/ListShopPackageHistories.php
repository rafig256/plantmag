<?php

namespace App\Filament\Resources\ShopPackageHistories\Pages;

use App\Filament\Resources\ShopPackageHistories\ShopPackageHistoryResource;
use Filament\Resources\Pages\ListRecords;

class ListShopPackageHistories extends ListRecords
{
    protected static string $resource = ShopPackageHistoryResource::class;

    
    public function getTitle(): string
    {
        return 'تاریخچه خرید بسته‌ها';
    }
}
