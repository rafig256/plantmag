<?php

namespace App\Filament\Resources\Plants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\Action;


class PlantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('🌱 نام گیاه')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('scientific_name')
                    ->label('🔬 نام علمی')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('family')
                    ->label('🌿 خانواده')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('min_price')
                    ->label('💰 حداقل قیمت')
                    ->formatStateUsing(fn ($state) => number_format($state) . ' تومان')
                    ->sortable(),

                TextColumn::make('max_price')
                    ->label('💰 حداکثر قیمت')
                    ->formatStateUsing(fn ($state) => number_format($state) . ' تومان')
                    ->sortable(),

                IconColumn::make('is_available')
                    ->label('موجود')
                    ->boolean(),

                TextColumn::make('views_count')
                    ->label('👁 بازدید')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('📅 تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('qr_code_path')
                    ->label('QR Code')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->square()
                    ->url(fn ($record) => asset('storage/' . $record->qr_code_path))
                    ->openUrlInNewTab(),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make()
                    ->label('ویرایش'),

                DeleteAction::make()
                    ->label('حذف'),

                Action::make('downloadQr')
                    ->label('دانلود QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('plants.download-qr', $record)),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف انتخابی'),
                ]),
            ]);
    }
}