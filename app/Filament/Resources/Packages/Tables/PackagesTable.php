<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('نام پکیج')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('شناسه')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('plant_count')
                    ->label('تعداد گیاه')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('has_qr')
                    ->label('QR')
                    ->boolean(),

                IconColumn::make('has_ai')
                    ->label('هوش مصنوعی')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

                TextColumn::make('price')
                    ->label('قیمت')
                    ->numeric()
                    ->suffix(' تومان')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('آخرین تغییر')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make()
                    ->label('ویرایش'),
            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->label('حذف انتخابی'),

                ]),

            ]);
    }
}