<?php

namespace App\Filament\Resources\Shops\Pages;

use App\Filament\Resources\Shops\ShopResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShop extends CreateRecord
{
    protected static string $resource = ShopResource::class;

    protected function afterCreate(): void
    {
        $this->record->owner()->update([
            'shop_id' => $this->record->id,
        ]);
    }
}
