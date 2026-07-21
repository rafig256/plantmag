<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'سایت گلفروشی یاس', 'type' => 'string', 'group' => 'general', 'label' => 'نام سایت'],
            ['key' => 'shop_name', 'value' => 'گلفروشی یاس', 'type' => 'string', 'group' => 'general', 'label' => 'نام گلفروشی'],
            ['key' => 'phone', 'value' => '045-32522222', 'type' => 'string', 'group' => 'contact', 'label' => 'تلفن'],
            ['key' => 'address', 'value' => 'مشگین شهر، خیابان امام، پاساژ جواهری', 'type' => 'string', 'group' => 'contact', 'label' => 'آدرس'],
            ['key' => 'currency', 'value' => 'تومان', 'type' => 'string', 'group' => 'general', 'label' => 'واحد پول'],
            ['key' => 'meta_description', 'value' => 'فروشگاه تخصصی گیاهان آپارتمانی', 'type' => 'string', 'group' => 'seo', 'label' => 'توضیحات متا'],
            ['key' => 'footer_text', 'value' => 'همه‌ی گیاهان با بهترین کیفیت', 'type' => 'string', 'group' => 'general', 'label' => 'متن فوتر'],
            ['key' => 'about_text', 'value' => 'متن درباره ما', 'type' => 'string', 'group' => 'general', 'label' => 'متن درباره ما'],
            ['key' => 'banner_image', 'value' => 'images/banner.jpg', 'type' => 'string', 'group' => 'general', 'label' => 'تصویر بنر'],
            ['key' => 'banner_alt', 'value' => 'بنر گلفروشی پاساژ', 'type' => 'string', 'group' => 'general', 'label' => 'متن جایگزین بنر'],
        ];

        foreach ($settings as $setting) {
            // اگر کلید وجود داشت، به‌روزرسانی کن، در غیر این صورت ایجاد کن
            Setting::updateOrCreate(
                ['key' => $setting['key']], // شرط پیدا کردن
                $setting // داده‌های جدید
            );
        }
    }
}
