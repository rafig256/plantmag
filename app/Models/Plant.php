<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shop;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class Plant extends Model
{
    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name', 'scientific_name', 'family', 'genus', 'order_name', 'class_name', 'origin', 'type',
        'water', 'light', 'temperature', 'humidity', 'soil', 'fertilizer', 'repotting', 'pruning', 'propagation',
        'growth_type', 'max_height', 'flowering_season', 'leaf_type', 'leaf_color', 'flower_color',
        'toxicity', 'difficulty',
        'description', 'short_description',
        'min_price', 'max_price', 'is_available',
        'featured_image', 'gallery_images',
        'qr_code_path', 'qr_code_url', 'views_count',
        'slug', 'meta_title', 'meta_description', 'meta_keywords','shop_id',
    ];
    protected $casts = [
        'gallery_images' => 'array',
        'min_price' => 'integer',
        'max_price' => 'integer',
        'views_count' => 'integer',
        'is_available' => 'boolean',
    ];
    public function generateQrCode(): void
    {
        // تولید لینک کامل صفحه گیاه
        $url = route('plants.show', $this->slug);
        
        // نام فایل QR Code
        $fileName = 'qrcodes/plant-' . $this->id . '.svg';
        
        // تولید QR Code به صورت SVG با سایز ۳۰۰
        $qrCode = QrCode::size(300)
            ->generate($url);
        
        // ذخیره در دیسک public (مسیر: storage/app/public/qrcodes/...)
        Storage::disk('public')->put($fileName, $qrCode);
        
        // ذخیره مسیر در دیتابیس
        $this->qr_code_path = $fileName;
        $this->saveQuietly(); // ذخیره بدون ایجاد رویدادهای اضافی
    }

    /**
     * حذف QR Code در صورت نیاز
     */
    public function deleteQrCode(): void
    {
        if ($this->qr_code_path) {
            Storage::disk('public')->delete($this->qr_code_path);
            $this->qr_code_path = null;
            $this->saveQuietly();
        }
    }

    protected static function booted()
    {
        static::creating(function ($plant) {

            $shop = Shop::findOrFail($plant->shop_id);

            if ($shop->plant_balance <= 0) {

                Notification::make()
                    ->title('اعتبار کافی نیست')
                    ->body('موجودی ثبت گیاه این فروشگاه به پایان رسیده است.')
                    ->danger()
                    ->send();

                throw ValidationException::withMessages([
                    'shop_id' => 'ابتدا باید یک پکیج برای این فروشگاه ثبت شود.',
                ]);
            }

            $shop->decrement('plant_balance');

        });

        static::created(function ($plant) {
            $plant->generateQrCode();
        });

        static::updated(function ($plant) {
            // اگر اسلاگ یا نام تغییر کرد، QR Code را دوباره تولید کن
            if ($plant->wasChanged('slug') || $plant->wasChanged('name')) {
                $plant->generateQrCode();
            }
        });

        static::deleted(function ($plant) {

            $plant->deleteQrCode();
            $plant->shop?->increment('plant_balance');

        });
    }
    // اضافه کردن رابطه
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    // اضافه کردن یک Scope برای فیلتر بر اساس فروشگاه فعلی
    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }
}
