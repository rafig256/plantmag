<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

}
