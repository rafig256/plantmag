<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'آزمایشی',
                'slug' => 'free',
                'description' => 'برای تست و آشنایی با سیستم',
                'plant_count' => 5,
                'has_qr' => true,
                'has_ai' => false,
                'price' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'پایه',
                'slug' => 'starter',
                'description' => 'مناسب برای شروع کار',
                'plant_count' => 20,
                'has_qr' => true,
                'has_ai' => false,
                'price' => 350000,
                'is_active' => true,
            ],
            [
                'name' => 'حرفه‌ای',
                'slug' => 'pro',
                'description' => 'برای گلفروشی‌های متوسط',
                'plant_count' => 50,
                'has_qr' => true,
                'has_ai' => true,
                'price' => 750000,
                'is_active' => true,
            ],
            [
                'name' => 'ویژه',
                'slug' => 'premium',
                'description' => 'همه‌ی امکانات برای فروشگاه‌های بزرگ',
                'plant_count' => 100,
                'has_qr' => true,
                'has_ai' => true,
                'price' => 1200000,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}