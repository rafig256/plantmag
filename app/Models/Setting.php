<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    protected $casts = [
        'value' => 'json', // برای ذخیره انواع داده
    ];

     public static function getCached($key = null, $default = null)
    {
        $settings = Cache::remember('settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });

        if ($key === null) {
            return $settings;
        }

        return $settings[$key] ?? $default;
    }

    // پاک کردن کش بعد از هر تغییر
    public static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('settings');
        });
    }
}
