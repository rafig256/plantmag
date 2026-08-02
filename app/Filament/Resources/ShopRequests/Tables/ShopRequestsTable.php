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
                        // جلوگیری از تأیید دوباره
                        if ($record->status !== 'pending') {
                            \Filament\Notifications\Notification::make()
                                ->title('این درخواست قبلاً پردازش شده است')
                                ->warning()
                                ->send();
                            return;
                        }

                        // شروع تراکنش دیتابیس
                        \Illuminate\Support\Facades\DB::beginTransaction();

                        try {
                            // 1. ایجاد کاربر جدید
                            $user = \App\Models\User::create([
                                'name' => $record->user_name,
                                'email' => $record->user_email,
                                'password' => $record->user_password ?? bcrypt(\Illuminate\Support\Str::random(10)),
                                'role' => 'manager', // مدیر فروشگاه
                                'shop_id' => null, // بعداً تنظیم می‌شود
                            ]);

                            // 2. ایجاد فروشگاه
                            $shop = \App\Models\Shop::create([
                                'name' => $record->shop_name,
                                'slug' => $record->shop_slug,
                                'phone' => $record->phone,
                                'address' => $record->address,
                                'about_text' => $record->about_text,
                                'currency' => 'تومان',
                                'owner_id' => $user->id,
                                'is_active' => true,
                                'plant_balance' => $record->package?->plant_count ?? 5, // موجودی اولیه از پکیج
                            ]);

                            // 3. به‌روزرسانی کاربر با shop_id
                            $user->shop_id = $shop->id;
                            $user->save();

                            // 4. ثبت تاریخچه خرید پکیج
                            if ($record->package_id) {
                                \App\Models\ShopPackageHistory::create([
                                    'shop_id' => $shop->id,
                                    'package_id' => $record->package_id,
                                    'plant_count' => $record->package->plant_count,
                                    'purchased_at' => now(),
                                    'payment_method' => 'manual',
                                    'payment_status' => 'paid',
                                    'note' => 'ایجاد فروشگاه از طریق درخواست #' . $record->id,
                                ]);
                            }

                            // 5. به‌روزرسانی وضعیت درخواست
                            $record->update([
                                'status' => 'approved',
                                'admin_note' => ($record->admin_note ? $record->admin_note . "\n" : '') . 'تأیید شده در ' . now()->format('Y/m-d H:i'),
                            ]);

                            \Illuminate\Support\Facades\DB::commit();

                            // ارسال نوتیفیکیشن موفقیت
                            \Filament\Notifications\Notification::make()
                                ->title('درخواست با موفقیت تأیید شد!')
                                ->body("فروشگاه {$shop->name} با مدیر {$user->name} ایجاد شد.")
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\DB::rollBack();

                            // ارسال نوتیفیکیشن خطا
                            \Filament\Notifications\Notification::make()
                                ->title('خطا در تأیید درخواست')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn ($record) => $record->status === 'pending')
                    ,

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