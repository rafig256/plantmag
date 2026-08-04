<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use App\Models\Package;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'address',
        'currency',
        'about_text',
        'footer_text',
        'banner_image',
        'banner_alt',
        'meta_description',
        'owner_id',
        'is_active',
        'plant_balance',
        'last_purchase_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expired_at' => 'datetime',
        'plant_limit' => 'integer',
        'plant_balance'   => 'integer',
        'last_purchase_at'=> 'datetime',
    ];

    // رابطه با صاحب فروشگاه (مدیر)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // رابطه با کاربران فروشگاه (کارمندان)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // رابطه با گیاهان
    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }

    // هلپر برای گرفتن تنظیمات
    public function getSetting(string $key, $default = null)
    {
        $settings = [
            'shop_name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'currency' => $this->currency,
            'about_text' => $this->about_text,
            'footer_text' => $this->footer_text,
            'banner_image' => $this->banner_image,
            'banner_alt' => $this->banner_alt,
            'meta_description' => $this->meta_description,
        ];

        return $settings[$key] ?? $default;
    }

    /**
     * تاریخچه خرید پکیج‌های فروشگاه
     */
    public function packageHistories(): HasMany
    {
        return $this->hasMany(ShopPackageHistory::class);
    }

    public function addPackage(Package $package, string $paymentMethod = 'manual', ?string $note = null): void
    {
        DB::transaction(function () use ($package, $paymentMethod, $note) {

            // ثبت تاریخچه خرید
            $this->packageHistories()->create([
                'package_id'      => $package->id,
                'plant_count'     => $package->plant_count,
                'payment_method'  => $paymentMethod,
                'payment_status'  => 'paid',
                'note'            => $note,
            ]);

            // افزایش موجودی گیاه
            $this->increment('plant_balance', $package->plant_count);

            // ثبت زمان آخرین خرید
            $this->update([
                'last_purchase_at' => now(),
            ]);

        });
    }
}