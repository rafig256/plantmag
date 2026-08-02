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
        Schema::create('shop_package_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->integer('plant_count'); // تعداد گیاهان این پکیج (برای ثبت در تاریخچه)
            $table->timestamp('purchased_at')->useCurrent();
            $table->string('payment_method')->default('online'); // online, offline, manual
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->text('note')->nullable(); // شماره فیش یا توضیحات
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_package_histories');
    }
};
