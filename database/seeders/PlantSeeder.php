<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        // پیدا کردن فروشگاه اول (برای shop_id)
        $shop = \App\Models\Shop::first();

        if (!$shop) {
            $this->command->warn('هیچ فروشگاهی یافت نشد! ابتدا ShopSeeder را اجرا کنید.');
            return;
        }

        $plants = [
            [
                // اطلاعات پایه
                'name' => 'بابا آدم',
                'scientific_name' => 'Alocasia amazonica',
                'family' => 'Araceae',
                'genus' => 'Alocasia',
                'order_name' => 'Alismatales',
                'class_name' => 'Liliopsida',
                'origin' => 'جنوب شرقی آسیا',
                'type' => 'علیف (گیاهی)',
                
                // مراقبت و نگهداری
                'water' => 'هر ۷ روز یکبار، زمانی که سطح خاک خشک شد',
                'light' => 'نور غیرمستقیم و روشن',
                'temperature' => '۱۸-۳۰ درجه سانتیگراد',
                'humidity' => '۶۰-۸۰٪',
                'soil' => 'خاک برگ + پرلیت + پیت ماس',
                'fertilizer' => 'کود مایع هر ماه در بهار و تابستان',
                'repotting' => 'هر ۲ سال یکبار در بهار',
                'pruning' => 'هرس برگ‌های خشک در پاییز',
                'propagation' => 'تقسیم بوته در بهار',
                
                // ویژگی‌های ظاهری و زیستی
                'growth_type' => 'چندساله',
                'max_height' => 'تا ۱۰۰ سانتیمتر',
                'flowering_season' => 'بهار و تابستان',
                'leaf_type' => 'قلبی شکل',
                'leaf_color' => 'سبز تیره با رگبرگ‌های مشخص',
                'flower_color' => 'سبز-سفید',
                
                // نکات ایمنی
                'toxicity' => 'سمی برای حیوانات خانگی',
                'difficulty' => 'متوسط',
                
                // محتوا
                'short_description' => 'یکی از زیباترین گیاهان آپارتمانی با برگ‌های پهن و قلبی شکل',
                'description' => 'بابا آدم با برگ‌های بزرگ و براق خود، جلوهای خاص به فضای داخلی می‌بخشد. این گیاه بومی جنگل‌های بارانی آسیای جنوب شرقی است و به دلیل ظاهر منحصربه‌فردش در دکوراسیون مدرن بسیار محبوب است. برای نگهداری از این گیاه، باید محیطی مرطوب و نور غیرمستقیم فراهم کنید.',
                
                // فروش و قیمت
                'min_price' => 350000,
                'max_price' => 600000,
                'is_available' => true,
                
                // تصاویر و رسانه
                'featured_image' => 'plants/alocasia.jpg',
                'gallery_images' => json_encode(['plants/alocasia-1.jpg', 'plants/alocasia-2.jpg', 'plants/alocasia-3.jpg']),
                
                // سئو
                'slug' => 'baba-adam',
                'meta_title' => 'بابا آدم | معرفی و نگهداری',
                'meta_description' => 'راهنمای کامل نگهداری از گیاه بابا آدم (Alocasia amazonica) شامل آبیاری، نور، دما و تکثیر',
                'meta_keywords' => 'بابا آدم, Alocasia, گیاه آپارتمانی, نگهداری گیاه',
                
                // shop_id
                'shop_id' => $shop->id,
            ],
            [
                // اطلاعات پایه
                'name' => 'زاموفیلیا',
                'scientific_name' => 'Zamioculcas zamiifolia',
                'family' => 'Araceae',
                'genus' => 'Zamioculcas',
                'order_name' => 'Alismatales',
                'class_name' => 'Liliopsida',
                'origin' => 'شرق آفریقا',
                'type' => 'علیف (گیاهی)',
                
                // مراقبت و نگهداری
                'water' => 'متوسط تا کم، اجازه دهید خاک کاملاً خشک شود',
                'light' => 'نور غیرمستقیم تا نیم‌سایه',
                'temperature' => '۱۸-۲۶ درجه سانتیگراد',
                'humidity' => '۴۰-۶۰٪',
                'soil' => 'خاک سبک با زهکشی عالی',
                'fertilizer' => 'کود مایع هر ۴-۶ هفته در بهار و تابستان',
                'repotting' => 'هر ۲-۳ سال یکبار در بهار',
                'pruning' => 'حذف برگ‌های زرد یا خشک شده',
                'propagation' => 'قلمه برگ یا تقسیم ریزوم',
                
                // ویژگی‌های ظاهری و زیستی
                'growth_type' => 'چندساله',
                'max_height' => '۴۵-۹۰ سانتیمتر',
                'flowering_season' => 'اواسط تابستان تا اوایل پاییز',
                'leaf_type' => 'برگ‌های براق و چرمی',
                'leaf_color' => 'سبز تیره براق',
                'flower_color' => 'زرد-قهوه‌ای (گلدهی در خانه نادر است)',
                
                // نکات ایمنی
                'toxicity' => 'سمی برای حیوانات خانگی و انسان',
                'difficulty' => 'آسان',
                
                // محتوا
                'short_description' => 'گیاهی مقاوم و بی‌دردسر با برگ‌های براق و جذاب',
                'description' => 'زاموفیلیا (ZZ Plant) یکی از مقاوم‌ترین گیاهان آپارتمانی است که در شرایط کم‌نوری و خشکی به خوبی دوام می‌آورد. این گیاه بومی شرق آفریقا است و به دلیل زیبایی برگ‌های براق و چرمی خود، در فضاهای اداری و خانگی بسیار محبوب است. نگهداری از این گیاه بسیار آسان است و برای افرادی که زمان کمی برای مراقبت از گیاهان دارند، گزینه‌ای عالی محسوب می‌شود.',
                
                // فروش و قیمت
                'min_price' => 150000,
                'max_price' => 400000,
                'is_available' => true,
                
                // تصاویر و رسانه
                'featured_image' => 'plants/zamioculcas.jpg',
                'gallery_images' => json_encode(['plants/zamioculcas-1.jpg', 'plants/zamioculcas-2.jpg']),
                
                // سئو
                'slug' => 'zamofilia',
                'meta_title' => 'زاموفیلیا | معرفی و نگهداری',
                'meta_description' => 'راهنمای کامل نگهداری از گیاه زاموفیلیا (Zamioculcas zamiifolia) شامل آبیاری، نور، دما و تکثیر',
                'meta_keywords' => 'زاموفیلیا, ZZ Plant, گیاه آپارتمانی, نگهداری گیاه',
                
                // shop_id
                'shop_id' => $shop->id,
            ],
        ];

        foreach ($plants as $plantData) {
            Plant::updateOrCreate(
                ['slug' => $plantData['slug']],
                $plantData
            );
        }
    }
}