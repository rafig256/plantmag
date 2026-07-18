<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Setting;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::where('is_available', true)
            ->orderBy('name')
            ->paginate(12);

        return view('plants.index', compact('plants'));
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
