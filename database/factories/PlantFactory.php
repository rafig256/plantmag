<?php

namespace Database\Factories;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plant>
 */
class PlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    // آرایه‌ای از نام‌های علمی و فارسی برای تنوع
    $names = ['بابا آدم', 'سانسوریا', 'گل یخ', 'بنفشه آفریقایی', 'پتوس'];
    $scientific = ['Alocasia amazonica', 'Sansevieria trifasciata', 'Schlumbergera', 'Saintpaulia', 'Epipremnum aureum'];
    $families = ['Araceae', 'Asparagaceae', 'Cactaceae', 'Gesneriaceae', 'Araceae'];
    $genera = ['Alocasia', 'Sansevieria', 'Schlumbergera', 'Saintpaulia', 'Epipremnum'];
    $origins = ['جنوب شرقی آسیا', 'آفریقای غربی', 'برزیل', 'تانزانیا', 'جزایر سلیمان'];
    
    // تولید یک نمونه تصادفی از آرایه‌ها
    $index = fake()->numberBetween(0, 4);
    $height = fake()->numberBetween(20, 200);
    
    return [
        // اطلاعات پایه
        'name' => $names[$index],
        'scientific_name' => $scientific[$index],
        'family' => $families[$index],
        'genus' => $genera[$index],
        'order_name' => fake()->randomElement(['Alismatales', 'Asparagales', 'Caryophyllales']),
        'class_name' => fake()->randomElement(['Liliopsida', 'Magnoliopsida']),
        'origin' => $origins[$index],
        'type' => fake()->randomElement(['علیف (گیاهی)', 'درختچه', 'کاکتوس', 'گلدار']),
        
        // مراقبت
        'water' => fake()->randomElement(['کم (هر ۱۰ روز)', 'متوسط (هفته‌ای ۲ بار)', 'زیاد (روزانه)']),
        'light' => fake()->randomElement(['نور غیرمستقیم', 'نور مستقیم', 'سایه کامل']),
        'temperature' => fake()->numberBetween(15, 35) . '°C',
        'humidity' => fake()->randomElement(['۳۰-۵۰٪', '۵۰-۷۰٪', '۷۰-۹۰٪']),
        'soil' => fake()->randomElement(['خاک برگ + پرلیت', 'ماسه + پیت ماس', 'خاک معمولی']),
        'fertilizer' => fake()->randomElement(['کود مایع هر ماه', 'کود جامد هر فصل']),
        'repotting' => fake()->randomElement(['هر ۱ سال', 'هر ۲ سال', 'هر ۳ سال']),
        'pruning' => fake()->randomElement(['هرس برگ‌های خشک', 'هرس در بهار']),
        'propagation' => fake()->randomElement(['قلمه برگ', 'تقسیم بوته', 'بذر']),
        
        // ظاهری
        'growth_type' => fake()->randomElement(['چندساله', 'یکساله', 'دوساله']),
        'max_height' => $height . ' سانتیمتر',
        'flowering_season' => fake()->randomElement(['بهار', 'تابستان', 'پاییز', 'همیشه']),
        'leaf_type' => fake()->randomElement(['پهن', 'قلبی', 'نیزه‌ای', 'سوزنی']),
        'leaf_color' => fake()->randomElement(['سبز تیره', 'سبز روشن', 'ارغوانی', 'ابلق']),
        'flower_color' => fake()->randomElement(['سفید', 'صورتی', 'زرد', 'نارنجی']),
        
        // ایمنی و نگهداری
        'toxicity' => fake()->randomElement(['سمی برای حیوانات', 'غیرسمی', 'تحریک‌کننده پوست']),
        'difficulty' => fake()->randomElement(['آسان', 'متوسط', 'سخت']),
        
        // محتوا
        'description' => fake()->paragraph(3),
        'short_description' => fake()->sentence(),
        
        // قیمت
        'min_price' => fake()->numberBetween(100000, 500000),
        'max_price' => fake()->numberBetween(600000, 1500000),
        'is_available' => fake()->boolean(80), // 80% شانس موجود بودن
        
        // تصاویر
        'featured_image' => 'plants/plant-' . fake()->numberBetween(1, 10) . '.jpg',
        'gallery_images' => json_encode(['plant1.jpg', 'plant2.jpg']),
        
        // آمار
        'views_count' => fake()->numberBetween(0, 500),
        
        // سئو
        'slug' => fake()->slug(2),
        'meta_title' => fake()->sentence(3),
        'meta_description' => fake()->sentence(6),
        'meta_keywords' => fake()->words(3, true),
    ];
}
}
