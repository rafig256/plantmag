<?php

namespace App\Filament\Resources\Shops\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use App\Models\Package;
use Filament\Forms\Components\Select;

use Filament\Tables\Table;

use App\Models\ShopPackageHistory;


class ShopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('نام فروشگاه')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('آدرس')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable(),

                TextColumn::make('owner.name')
                    ->label('مدیر فروشگاه')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

                TextColumn::make('plant_balance')
                    ->label('موجودی گیاه')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('last_purchase_at')
                    ->label('آخرین خرید')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(),

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

                Action::make('assignPackage')
                    ->label('تخصیص پکیج')
                    ->icon('heroicon-o-gift')
                    ->color('success')
                    ->form([

                        Select::make('package_id')
                            ->label('پکیج')
                            ->options(
                                Package::query()
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),

                    ])
                    ->visible(fn () => auth()->user()?->role === 'admin')

                    ->action(function (array $data, $record) {

                        $package = Package::findOrFail($data['package_id']);

                        $record->addPackage(
                            $package,
                            paymentMethod: 'manual',
                            note: 'اختصاص توسط مدیر'
                        );

                        \Filament\Notifications\Notification::make()
                            ->title('پکیج ثبت شد')
                            ->body("پکیج «{$package->name}» به فروشگاه اضافه شد.")
                            ->success()
                            ->send();

                    }),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->label('حذف انتخابی'),

                ]),

            ]);
    }
}