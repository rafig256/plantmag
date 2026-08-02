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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "پایه"، "حرفه‌ای"، "ویژه"
            $table->string('slug')->unique(); // starter, pro, premium
            $table->text('description')->nullable();
            $table->integer('plant_count'); // تعداد گیاهانی که در این پکیج ارائه می‌شود
            $table->boolean('has_qr')->default(true);
            $table->boolean('has_ai')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('price')->nullable(); // قیمت به تومان (برای نمایش)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
