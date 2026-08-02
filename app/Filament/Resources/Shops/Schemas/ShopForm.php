<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('اطلاعات اصلی فروشگاه')
                    ->schema([

                        TextInput::make('name')
                            ->label('نام فروشگاه')
                            ->required(),

                        TextInput::make('slug')
                            ->label('آدرس فروشگاه (Slug)')
                            ->required(),

                        TextInput::make('phone')
                            ->label('تلفن')
                            ->tel(),

                        TextInput::make('address')
                            ->label('آدرس'),

                        TextInput::make('currency')
                            ->label('واحد پول')
                            ->required()
                            ->default('تومان'),

                    ])
                    ->columns(2),


                Section::make('محتوای فروشگاه')
                    ->schema([

                        Textarea::make('about_text')
                            ->label('درباره فروشگاه')
                            ->columnSpanFull(),

                        Textarea::make('footer_text')
                            ->label('متن فوتر')
                            ->columnSpanFull(),

                        FileUpload::make('banner_image')
                            ->label('تصویر بنر')
                            ->image()
                            ->directory('shops/banners'),

                        TextInput::make('banner_alt')
                            ->label('متن جایگزین تصویر'),

                        TextInput::make('meta_description')
                            ->label('توضیحات متا'),

                    ])
                    ->columns(2),


                Section::make('مدیریت فروشگاه')
                    ->schema([

                        Placeholder::make('owner_name')
                            ->label('مدیر فروشگاه')
                            ->content(fn ($record) =>
                                $record?->owner?->name ?? '---'
                            ),

                        Toggle::make('is_active')
                            ->label('وضعیت فعالیت')
                            ->default(true),

                        TextInput::make('plant_balance')
                            ->label('موجودی گیاه')
                            ->numeric()
                            ->required()
                            ->default(0),

                        Placeholder::make('last_purchase_at')
                            ->label('آخرین خرید')
                            ->content(fn ($record) =>
                                $record?->last_purchase_at
                                    ? $record->last_purchase_at->format('Y/m/d H:i')
                                    : 'هنوز خریدی ثبت نشده است'
                            ),

                    ])
                    ->columns(2),

            ]);
    }
}