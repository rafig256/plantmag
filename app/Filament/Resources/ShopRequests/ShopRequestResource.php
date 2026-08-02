<?php

namespace App\Filament\Resources\ShopRequests;

use App\Filament\Resources\ShopRequests\Pages\CreateShopRequest;
use App\Filament\Resources\ShopRequests\Pages\EditShopRequest;
use App\Filament\Resources\ShopRequests\Pages\ListShopRequests;
use App\Filament\Resources\ShopRequests\Schemas\ShopRequestForm;
use App\Filament\Resources\ShopRequests\Tables\ShopRequestsTable;
use App\Models\ShopRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShopRequestResource extends Resource
{
    protected static ?string $model = ShopRequest::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $recordTitleAttribute = 'shop_name';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت فروشگاه‌ها';
    protected static ?string $label = 'درخواست فروشگاه';
    protected static ?string $pluralLabel = 'درخواست‌های فروشگاه';

    public static function form(Schema $schema): Schema
    {
        return ShopRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShopRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShopRequests::route('/'),
            'create' => CreateShopRequest::route('/create'),
            'edit' => EditShopRequest::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()?->role === 'admin';
    }
}
