<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('plants', function (Blueprint $table) {
        $table->id();
        
        // اطلاعات پایه
        $table->string('name')->comment('نام فارسی گیاه');
        $table->string('scientific_name')->nullable()->comment('نام علمی');
        $table->string('family')->nullable()->comment('خانواده');
        $table->string('genus')->nullable()->comment('سرده');
        $table->string('order_name')->nullable()->comment('راسته');
        $table->string('class_name')->nullable()->comment('کلاس');
        $table->string('origin')->nullable()->comment('منشأ');
        $table->string('type')->nullable()->comment('نوع گیاه (علیف، درختچه و...)');
        
        // مراقبت و نگهداری
        $table->string('water')->nullable()->comment('میزان آبیاری');
        $table->string('light')->nullable()->comment('نیاز نوری');
        $table->string('temperature')->nullable()->comment('دمای مناسب');
        $table->string('humidity')->nullable()->comment('رطوبت مورد نیاز');
        $table->string('soil')->nullable()->comment('خاک مناسب');
        $table->string('fertilizer')->nullable()->comment('کود مورد نیاز');
        $table->string('repotting')->nullable()->comment('تعویض گلدان');
        $table->string('pruning')->nullable()->comment('هرس کردن');
        $table->string('propagation')->nullable()->comment('تکثیر');
        
        // ویژگی‌های ظاهری و زیستی
        $table->string('growth_type')->nullable()->comment('نوع رشد (چندساله، یکساله)');
        $table->string('max_height')->nullable()->comment('حداکثر ارتفاع');
        $table->string('flowering_season')->nullable()->comment('فصل گلدهی');
        $table->string('leaf_type')->nullable()->comment('نوع برگ');
        $table->string('leaf_color')->nullable()->comment('رنگ برگ');
        $table->string('flower_color')->nullable()->comment('رنگ گل');
        
        // نکات ایمنی
        $table->string('toxicity')->nullable()->comment('سمیت برای حیوانات یا انسان');
        $table->string('difficulty')->nullable()->comment('سطح نگهداری');
        
        // محتوا
        $table->text('description')->nullable()->comment('توضیحات کامل');
        $table->text('short_description')->nullable()->comment('توضیحات کوتاه');
        
        // فروش و قیمت (همان درخواست شما)
        $table->decimal('min_price', 10, 0)->nullable()->comment('حداقل قیمت');
        $table->decimal('max_price', 10, 0)->nullable()->comment('حداکثر قیمت');
        $table->boolean('is_available')->default(true)->comment('موجودی');
        
        // تصاویر و رسانه
        $table->string('featured_image')->nullable()->comment('تصویر شاخص');
        $table->json('gallery_images')->nullable()->comment('گالری تصاویر');
        
        // QR کد و آمار
        $table->string('qr_code_path')->nullable()->comment('مسیر فایل QR کد');
        $table->string('qr_code_url')->nullable()->comment('لینک QR کد');
        $table->unsignedInteger('views_count')->default(0)->comment('تعداد بازدید');
        
        // سئو
        $table->string('slug')->unique()->comment('اسلاگ برای سئو');
        $table->string('meta_title')->nullable()->comment('عنوان متا');
        $table->text('meta_description')->nullable()->comment('توضیحات متا');
        $table->string('meta_keywords')->nullable()->comment('کلمات کلیدی متا');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
