<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('address')
                    ->default(null),
                TextInput::make('currency')
                    ->required()
                    ->default('تومان'),
                Textarea::make('about_text')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('footer_text')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('banner_image')
                    ->image(),
                TextInput::make('banner_alt')
                    ->default(null),
                TextInput::make('meta_description')
                    ->default(null),
                Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('plant_balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_purchase_at'),
            ]);
    }
}
