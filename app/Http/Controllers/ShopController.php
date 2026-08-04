<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Plant;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * نمایش صفحه اصلی یک فروشگاه (لیست گیاهان)
     */
    public function index($shop_slug)
    {
        // پیدا کردن فروشگاه
        $shop = Shop::where('slug', $shop_slug)
            ->where('is_active', true)
            ->firstOrFail();

        // دریافت گیاهان این فروشگاه (فقط موجودها)
        $plants = Plant::where('shop_id', $shop->id)
            ->where('is_available', true)
            ->orderBy('name')
            ->paginate(12);

        return view('shop.index', compact('shop', 'plants'));
    }

    /**
     * صفحه درباره فروشگاه
     */
    public function about($shop_slug)
    {
        $shop = Shop::where('slug', $shop_slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('shop.about', compact('shop'));
    }
}