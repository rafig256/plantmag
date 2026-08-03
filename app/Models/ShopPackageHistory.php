<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopPackageHistory extends Model
{
    protected $table = 'shop_package_history';

    protected $fillable = [
        'shop_id',
        'package_id',
        'plant_count',
        'purchased_at',
        'payment_method',
        'payment_status',
        'note',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'plant_count' => 'integer',
    ];


    /**
     * فروشگاهی که این پکیج را خریداری کرده است
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }


    /**
     * پکیج خریداری شده
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }


    /**
     * عنوان خوانا برای نمایش
     */
    public function getTitleAttribute(): string
    {
        return ($this->shop?->name ?? '---')
            . ' - '
            . ($this->package?->name ?? '---');
    }
}