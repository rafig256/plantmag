<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

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

        // افزایش تعداد بازدید
        $plant->increment('views_count');

        return view('plants.show', compact('plant'));
    }
}
