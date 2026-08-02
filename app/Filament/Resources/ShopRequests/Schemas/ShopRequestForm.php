<?php

namespace App\Filament\Resources\ShopRequests\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ShopRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('shop_name')
                    ->required(),
                TextInput::make('shop_slug')
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
                FileUpload::make('banner_image')
                    ->image(),
                TextInput::make('user_name')
                    ->required(),
                TextInput::make('user_email')
                    ->email()
                    ->required(),
                TextInput::make('user_password')
                    ->password()
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('package_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
