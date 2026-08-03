<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('نام پکیج')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('مثلاً: حرفه‌ای'),

                TextInput::make('slug')
                    ->label('شناسه انگلیسی (Slug)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('مثلاً: professional'),

                Textarea::make('description')
                    ->label('توضیحات پکیج')
                    ->default(null)
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('plant_count')
                    ->label('تعداد گیاه قابل ثبت')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->helperText('تعداد گیاهانی که این پکیج به فروشگاه اضافه می‌کند.'),

                Toggle::make('has_qr')
                    ->label('امکان استفاده از QR')
                    ->default(true),

                Toggle::make('has_ai')
                    ->label('امکان استفاده از هوش مصنوعی')
                    ->default(false),

                Toggle::make('is_active')
                    ->label('فعال بودن پکیج')
                    ->default(true),

                TextInput::make('price')
                    ->label('قیمت پکیج (تومان)')
                    ->numeric()
                    ->minValue(0)
                    ->default(null)
                    ->suffix('تومان'),

            ]);
    }
}