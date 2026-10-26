<?php

namespace App\Filament\Resources\ShopPackageHistories;

use App\Filament\Resources\ShopPackageHistories\Pages\ListShopPackageHistories;
use App\Filament\Resources\ShopPackageHistories\Tables\ShopPackageHistoriesTable;
use App\Models\ShopPackageHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShopPackageHistoryResource extends Resource
{
    protected static ?string $model = ShopPackageHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationLabel(): string
    {
        return 'تاریخچه خرید بسته‌ها';
    }

    public static function getBreadcrumb(): string
    {
        return 'تاریخچه خرید بسته‌ها';
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user !== null
            && (
                $user->role === 'admin'
                || $user->ownedShop()->exists()
            );
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->role === 'admin') {
            return $query;
        }

        $shop = $user->ownedShop;

        if (! $shop) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('shop_id', $shop->id);
    }

    public static function table(Table $table): Table
    {
        return ShopPackageHistoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShopPackageHistories::route('/'),
        ];
    }
}