<?php

namespace App\Filament\Resources\ShopRequests\Schemas;

use App\Models\Package;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;

class ShopRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('اطلاعات فروشگاه')
                    ->icon('heroicon-o-building-storefront')
                    ->collapsible()
                    ->schema([

                        TextInput::make('shop_name')
                            ->label('نام فروشگاه')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('shop_slug')
                            ->label('آدرس فروشگاه (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        TextInput::make('phone')
                            ->label('تلفن')
                            ->tel()
                            ->maxLength(20),

                        TextInput::make('address')
                            ->label('آدرس')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('about_text')
                            ->label('درباره فروشگاه')
                            ->columnSpanFull(),

                    ])
                    ->columns(2),


                Section::make('اطلاعات مدیر فروشگاه')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->schema([

                        TextInput::make('user_name')
                            ->label('نام مدیر')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('user_email')
                            ->label('ایمیل')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('user_password')
                            ->label('رمز عبور')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(
                                fn ($state) => filled($state) ? bcrypt($state) : null
                            )
                            ->columnSpanFull(),

                    ])
                    ->columns(2),


                Section::make('پکیج')
    ->icon('heroicon-o-credit-card')
    ->collapsible()
    ->schema([

        Fieldset::make('انتخاب پکیج')
            ->schema([

                Select::make('package_id')
                    ->label('پکیج')
                    ->relationship('package', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {

                        $package = Package::find($state);

                        $set('package_name', $package?->name);

                        $set(
                            'package_plant_count',
                            $package?->plant_count
                        );
                    }),

                TextInput::make('package_name')
                    ->label('نام پکیج')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('package_plant_count')
                    ->label('تعداد گیاهان مجاز')
                    ->disabled()
                    ->numeric()
                    ->dehydrated(false),

            ])
            ->columns(3)
            ->columnSpanFull(),

    ]),


Section::make('وضعیت درخواست')
    ->schema([

        Select::make('status')
            ->label('وضعیت')
            ->options([
                'pending' => 'در انتظار',
                'approved' => 'تأیید شده',
                'rejected' => 'رد شده',
            ])
            ->required()
            ->default('pending'),

    ]),


Section::make('یادداشت ادمین')
    ->schema([

        Textarea::make('admin_note')
            ->label('یادداشت داخلی')
            ->rows(4)
            ->columnSpanFull(),

    ]),

            ]);
    }
}