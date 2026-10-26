<?php

namespace App\Filament\Resources\ShopPackageHistories;

use App\Filament\Resources\ShopPackageHistories\Pages\CreateShopPackageHistory;
use App\Filament\Resources\ShopPackageHistories\Pages\EditShopPackageHistory;
use App\Filament\Resources\ShopPackageHistories\Pages\ListShopPackageHistories;
use App\Filament\Resources\ShopPackageHistories\Schemas\ShopPackageHistoryForm;
use App\Filament\Resources\ShopPackageHistories\Tables\ShopPackageHistoriesTable;
use App\Models\ShopPackageHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShopPackageHistoryResource extends Resource
{
    protected static ?string $model = ShopPackageHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ShopPackageHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShopPackageHistoriesTable::configure($table);
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
            'index' => ListShopPackageHistories::route('/'),
            'create' => CreateShopPackageHistory::route('/create'),
            'edit' => EditShopPackageHistory::route('/{record}/edit'),
        ];
    }
}
