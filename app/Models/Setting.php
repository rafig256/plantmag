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

    // کش کردن برای کاهش کوئری
    public static function getCached($key, $default = null)
    {
        $settings = Cache::remember('settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    // clear cache بعد از هر تغییر
    public static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('settings');
        });
    }
}
