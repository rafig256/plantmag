<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    protected $fillable = [
        'name', 'slug', 'phone', 'address', 'currency',
        'about_text', 'footer_text', 'banner_image', 'banner_alt', 'meta_description',
        'owner_id', 'is_active', 'package_type', 'plant_limit', 'expired_at','plant_balance'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expired_at' => 'datetime',
        'plant_limit' => 'integer',
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
}