<?php

namespace App\Filament\Resources\Packages;

use App\Filament\Resources\Packages\Pages\CreatePackage;
use App\Filament\Resources\Packages\Pages\EditPackage;
use App\Filament\Resources\Packages\Pages\ListPackages;
use App\Filament\Resources\Packages\Schemas\PackageForm;
use App\Filament\Resources\Packages\Tables\PackagesTable;
use App\Models\Package;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    // آیکون منو
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    // عنوان رکورد
    protected static ?string $recordTitleAttribute = 'name';

    // فارسی‌سازی
    protected static ?string $label = 'پکیج';

    protected static ?string $pluralLabel = 'پکیج‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت فروشگاه‌ها';

    public static function form(Schema $schema): Schema
    {
        return PackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PackagesTable::configure($table);
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
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()?->role === 'admin';
    }

    public static function getNavigationBadge(): ?string
    {
        return auth()->user()?->role === 'admin'
            ? (string) static::getModel()::count()
            : null;
    }
}