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

    [
        'key' => 'site_name',
        'value' => 'سایت گلفروشی یاس',
        'type' => 'text',
        'group' => 'general',
        'label' => 'نام سایت',
    ],

    [
        'key' => 'shop_name',
        'value' => 'گلفروشی یاس',
        'type' => 'text',
        'group' => 'general',
        'label' => 'نام گلفروشی',
    ],

    [
        'key' => 'phone',
        'value' => '045-32522222',
        'type' => 'text',
        'group' => 'contact',
        'label' => 'تلفن',
    ],

    [
        'key' => 'address',
        'value' => 'مشگین شهر، خیابان امام، پاساژ جواهری',
        'type' => 'textarea',
        'group' => 'contact',
        'label' => 'آدرس',
    ],

    [
        'key' => 'currency',
        'value' => 'تومان',
        'type' => 'text',
        'group' => 'general',
        'label' => 'واحد پول',
    ],

    [
        'key' => 'meta_description',
        'value' => 'فروشگاه تخصصی گیاهان آپارتمانی',
        'type' => 'textarea',
        'group' => 'seo',
        'label' => 'توضیحات متا',
    ],

    [
        'key' => 'footer_text',
        'value' => 'همه‌ی گیاهان با بهترین کیفیت',
        'type' => 'textarea',
        'group' => 'general',
        'label' => 'متن فوتر',
    ],

    [
        'key' => 'about_text',
        'value' => 'متن درباره ما',
        'type' => 'textarea',
        'group' => 'general',
        'label' => 'متن درباره ما',
    ],

    [
        'key' => 'banner_image',
        'value' => 'settings/banner.jpg',
        'type' => 'image',
        'group' => 'general',
        'label' => 'تصویر بنر',
    ],

    [
        'key' => 'banner_alt',
        'value' => 'بنر گلفروشی یاس',
        'type' => 'text',
        'group' => 'general',
        'label' => 'متن جایگزین بنر',
    ],
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
