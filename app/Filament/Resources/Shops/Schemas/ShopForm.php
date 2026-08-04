<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
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

                /*
                |--------------------------------------------------------------------------
                | اطلاعات اصلی
                |--------------------------------------------------------------------------
                */

                Section::make('اطلاعات اصلی فروشگاه')
                    ->columns(2)
                    ->schema([

                        TextInput::make('name')
                            ->label('نام فروشگاه')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('آدرس فروشگاه (Slug)')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('phone')
                            ->label('تلفن')
                            ->maxLength(20),

                        TextInput::make('address')
                            ->label('آدرس'),

                        TextInput::make('currency')
                            ->label('واحد پول')
                            ->default('تومان')
                            ->required(),

                    ]),

                /*
                |--------------------------------------------------------------------------
                | محتوای فروشگاه
                |--------------------------------------------------------------------------
                */

                Section::make('محتوای فروشگاه')
                    ->columns(2)
                    ->schema([

                        Textarea::make('about_text')
                            ->label('درباره فروشگاه')
                            ->rows(5)
                            ->columnSpanFull(),

                        Textarea::make('footer_text')
                            ->label('متن فوتر')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('banner_image')
                            ->label('تصویر بنر')
                            ->image()
                            ->directory('shops/banners'),

                        TextInput::make('banner_alt')
                            ->label('متن جایگزین تصویر'),

                        TextInput::make('meta_description')
                            ->label('توضیحات متا')
                            ->columnSpanFull(),

                    ]),

                /*
                |--------------------------------------------------------------------------
                | مدیریت فروشگاه
                |--------------------------------------------------------------------------
                */

                Section::make('مدیریت فروشگاه')
                    ->columns(2)
                    ->visible(fn () => auth()->user()?->role === 'admin')
                    ->schema([

                        /*
                         | هنگام ایجاد فروشگاه
                         */

                        Select::make('owner_id')
                            ->label('مدیر فروشگاه')
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->required()
                            ->visibleOn('create'),

                        /*
                         | هنگام ویرایش
                         */

                        Placeholder::make('owner_name')
                            ->label('مدیر فروشگاه')
                            ->content(fn ($record) => $record?->owner?->name ?? '-')
                            ->visibleOn('edit'),

                        Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true),

                        TextInput::make('plant_balance')
                            ->label('موجودی گیاه')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->visibleOn('edit')
                            ->helperText('تعداد گیاهانی که این فروشگاه مجاز به ثبت آن‌ها است.'),

                        Placeholder::make('last_purchase_at')
                            ->label('آخرین خرید')
                            ->content(fn ($record) =>
                                $record?->last_purchase_at
                                    ? $record->last_purchase_at->format('Y/m/d H:i')
                                    : 'هنوز خریدی ثبت نشده است'
                            )
                            ->visibleOn('edit'),

                    ]),

            ]);
    }
}