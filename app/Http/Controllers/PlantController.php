<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Setting;

class PlantController extends Controller
{
    public function index()
    {
        // کوئری اصلی برای صفحه‌بندی (همه گیاهان موجود)
        $plants = Plant::where('is_available', true)
            ->orderBy('name')
            ->paginate(12);

        // کوئری برای اسلایدر گیاهان (تا ۸ عدد، بر اساس جدیدترین)
        $sliderPlants = Plant::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // کوئری برای اسلایدر محبوب‌ترین (تا ۸ عدد، بر اساس بیشترین بازدید)
        $popularPlants = Plant::where('is_available', true)
            ->orderBy('views_count', 'desc')
            ->take(4)
            ->get();

        return view('plants.index', compact('plants', 'sliderPlants', 'popularPlants'));
    }  

     public function show($slug)
    {
        $plant = Plant::where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();
        $currency = Setting::where('key', 'currency')->first()->value ?? 'تومان';

        // افزایش تعداد بازدید
        $plant->increment('views_count');

        return view('plants.show', compact('plant','currency'));
    }
}
