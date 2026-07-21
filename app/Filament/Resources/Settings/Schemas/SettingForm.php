<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->disabled(),
                    match ($schema->getRecord()?->type) {
                        'text' => TextInput::make('value')
                            ->label('مقدار'),
                        'textarea' => Textarea::make('value')
                            ->label('مقدار')
                            ->columnSpanFull(),
                        'image' => FileUpload::make('value')
                            ->label('تصویر')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->visibility('public')
                            ->imageEditor(),

                        default => TextInput::make('value'),
                    },
                TextInput::make('type')
                    ->required()
                    ->default('string')
                    ->disabled(),
                TextInput::make('group')
                    ->required()
                    ->default('general')
                    ->disabled(),
                TextInput::make('label')
                    ->default(null),
            ]);
    }
}
