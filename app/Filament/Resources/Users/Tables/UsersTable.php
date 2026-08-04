<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable(),

                TextColumn::make('shop.name')
                    ->label('فروشگاه')
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('role')
                    ->label('نقش')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'مدیر کل',
                        'manager' => 'مدیر فروشگاه',
                        'staff' => 'کارمند',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'manager',
                        'success' => 'staff',
                    ]),

                IconColumn::make('email_verified_at')
                    ->label('ایمیل تأیید شده')
                    ->boolean(fn ($record) => $record->email_verified_at !== null),

                TextColumn::make('created_at')
                    ->label('تاریخ عضویت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('آخرین ویرایش')
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