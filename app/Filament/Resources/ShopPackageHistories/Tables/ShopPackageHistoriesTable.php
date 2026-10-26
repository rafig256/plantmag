<?php

namespace App\Filament\Resources\ShopPackageHistories\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShopPackageHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchased_at')
                    ->label('تاریخ خرید')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),

                TextColumn::make('shop.name')
                    ->label('نام فروشگاه')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('package.name')
                    ->label('نام بسته')
                    ->searchable(),

                TextColumn::make('plant_count')
                    ->label('تعداد گیاه')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('روش پرداخت'),

                TextColumn::make('payment_status')
                    ->label('وضعیت پرداخت')
                    ->badge(),

                TextColumn::make('note')
                    ->label('توضیحات')
                    ->placeholder('—')
                    ->wrap(),
            ])
            ->defaultSort('purchased_at', 'desc');
    }
}