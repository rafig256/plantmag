<?php

namespace App\Filament\Resources\ShopPackageHistories\Pages;

use App\Filament\Resources\ShopPackageHistories\ShopPackageHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShopPackageHistory extends EditRecord
{
    protected static string $resource = ShopPackageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
