<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            // پکیج آزمایشی (free) را پیدا کن
            $freePackage = Package::where('slug', 'free')->first();

            $shop = Shop::create([
                'name' => 'گلفروشی پاساژ',
                'slug' => 'gol-pasaj',
                'phone' => '۰۲۱-۱۲۳۴۵۶۷۸',
                'address' => 'مشگین شهر، خیابان امام، پاساژ جواهری',
                'currency' => 'تومان',
                'about_text' => 'گلفروشی پاساژ با سال‌ها تجربه ...',
                'footer_text' => 'همه‌ی گیاهان با بهترین کیفیت',
                'banner_image' => 'images/banner.jpg',
                'banner_alt' => 'بنر گلفروشی پاساژ',
                'owner_id' => $user->id,
                'is_active' => true,
                'plant_balance' => $freePackage->plant_count ?? 5, // موجودی اولیه
            ]);

            // ثبت تاریخچه خرید
            if ($freePackage) {
                \App\Models\ShopPackageHistory::create([
                    'shop_id' => $shop->id,
                    'package_id' => $freePackage->id,
                    'plant_count' => $freePackage->plant_count,
                    'purchased_at' => now(),
                    'payment_method' => 'manual',
                    'payment_status' => 'paid',
                    'note' => 'پکیج آزمایشی اولیه',
                ]);
            }

            $user->shop_id = $shop->id;
            $user->role = 'manager';
            $user->save();

            // به‌روزرسانی گیاهان موجود (اگر قبلاً گیاهی وجود دارد)
            \App\Models\Plant::query()->update(['shop_id' => $shop->id]);
        }
    }
}