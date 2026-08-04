<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('اطلاعات کاربر')
                    ->schema([

                        TextInput::make('name')
                            ->label('نام')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('رمز عبور')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->helperText('در ویرایش، برای حفظ رمز عبور فعلی این قسمت را خالی بگذارید.'),

                    ])
                    ->columns(2),

                Section::make('دسترسی')
                    ->schema([

                        Select::make('role')
                            ->label('نقش')
                            ->options([
                                'admin' => 'مدیر کل',
                                'manager' => 'مدیر فروشگاه',
                                'staff' => 'کارمند',
                            ])
                            ->required()
                            ->default('staff')
                            ->native(false),

                        Select::make('shop_id')
                            ->label('فروشگاه')
                            ->relationship('shop', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('بدون فروشگاه')
                            ->helperText('برای مدیران فروشگاه و کارمندان استفاده می‌شود.')
                            ->native(false),

                    ])
                    ->columns(2),

            ]);
    }
}