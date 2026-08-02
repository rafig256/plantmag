<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            
            // اطلاعات اصلی فروشگاه
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('currency')->default('تومان');
            
            // محتوای صفحه‌ها
            $table->text('about_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_alt')->nullable();
            $table->string('meta_description')->nullable();
            
            // اطلاعات کاربری و مدیریت
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            
            // وضعیت فروشگاه
            $table->boolean('is_active')->default(true);
            
            // 🔽 سیستم موجودی جدید (به جای پکیج‌های زمان‌دار)
            $table->integer('plant_balance')->default(0); // تعداد گیاهان موجود در حساب فروشگاه
            $table->timestamp('last_purchase_at')->nullable(); // تاریخ آخرین خرید
            
            $table->timestamps();
        });

        // اضافه کردن shop_id به جدول users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('shop_id')
                ->nullable() // مقدار پیش‌فرض NULL
                ->constrained('shops')
                ->nullOnDelete();
            $table->enum('role', ['admin', 'manager', 'staff'])->default('staff');
        });

        // اضافه کردن shop_id به جدول plants
        Schema::table('plants', function (Blueprint $table) {
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // حذف کلیدهای خارجی در order صحیح
        Schema::table('plants', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });
        
        Schema::dropIfExists('shops');
    }
};