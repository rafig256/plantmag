<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_requests', function (Blueprint $table) {
            $table->id();
            
            // اطلاعات فروشگاه (توسط کاربر پر می‌شود)
            $table->string('shop_name');
            $table->string('shop_slug')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('currency')->default('تومان');
            $table->text('about_text')->nullable();
            $table->string('banner_image')->nullable();
            
            // اطلاعات کاربر (توسط کاربر پر می‌شود)
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->string('user_password'); // هش شده
            
            // وضعیت درخواست
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // یادداشت ادمین
            
            // پکیج درخواستی (اختیاری)
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            
            $table->timestamps();
            
            // ایندکس‌ها
            $table->index('status');
            $table->index('user_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_requests');
    }
};