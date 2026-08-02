<?php

namespace App\Filament\Resources\ShopRequests\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ShopRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('شماره')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('shop_name')
                    ->label('نام فروشگاه')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user_name')
                    ->label('مدیر')
                    ->searchable(),

                TextColumn::make('user_email')
                    ->label('ایمیل')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('تلفن')
                    ->toggleable(),

                TextColumn::make('package.name')
                    ->label('پکیج')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'در انتظار',
                        'approved' => 'تأیید شده',
                        'rejected' => 'رد شده',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار',
                        'approved' => 'تأیید شده',
                        'rejected' => 'رد شده',
                    ]),

                SelectFilter::make('package_id')
                    ->label('پکیج')
                    ->relationship('package', 'name'),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('ویرایش')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-o-trash'),

                Action::make('approve')
                    ->label('تأیید')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                        ]);
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),

                Action::make('reject')
                    ->label('رد')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف انتخابی'),
                ]),
            ]);
    }
}