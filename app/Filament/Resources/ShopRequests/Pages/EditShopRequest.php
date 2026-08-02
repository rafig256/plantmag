<?php

namespace App\Filament\Resources\ShopRequests\Pages;

use App\Filament\Resources\ShopRequests\ShopRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShopRequest extends EditRecord
{
    protected static string $resource = ShopRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
