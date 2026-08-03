<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'plant_count',
        'has_qr',
        'has_ai',
        'is_active',
        'price',
    ];

    protected $casts = [
        'plant_count' => 'integer',
        'price' => 'integer',
        'has_qr' => 'boolean',
        'has_ai' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * تاریخچه خرید این پکیج
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ShopPackageHistory::class);
    }

    /**
     * فقط برای نمایش در Select ها
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} ({$this->plant_count} گیاه)";
    }
}