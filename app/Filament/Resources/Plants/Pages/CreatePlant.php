<?php

namespace App\Filament\Resources\Plants\Pages;

use App\Filament\Resources\Plants\PlantResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlant extends CreateRecord
{
    protected static string $resource = PlantResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()->role !== 'admin') {
            $data['shop_id'] = auth()->user()->shop_id;
        }

        return $data;
    }
}