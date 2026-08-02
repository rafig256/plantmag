<?php

namespace App\Filament\Resources\ShopRequests\Pages;

use App\Filament\Resources\ShopRequests\ShopRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShopRequests extends ListRecords
{
    protected static string $resource = ShopRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
