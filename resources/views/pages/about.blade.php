@extends('layouts.app')

@section('title', 'درباره ما')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-6">🌿 درباره ما</h1>
        
        <div class="prose prose-green max-w-none">
            <p class="text-gray-700 leading-relaxed">
                {{ $settings['about_text'] ?? 'گلفروشی پاساژ با سال‌ها تجربه در زمینه‌ی پرورش و فروش گیاهان آپارتمانی و فضای باز، همواره کوشیده است تا بهترین و باکیفیت‌ترین گیاهان را به مشتریان عزیز ارائه دهد.' }}
            </p>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl mb-2">🌱</div>
                    <h3 class="font-bold text-gray-800">کیفیت بالا</h3>
                    <p class="text-sm text-gray-600">انتخاب بهترین گیاهان</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-2">💚</div>
                    <h3 class="font-bold text-gray-800">تضمین سلامت</h3>
                    <p class="text-sm text-gray-600">گیاهان سالم و شاداب</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-2">🌿</div>
                    <h3 class="font-bold text-gray-800">مشاوره رایگان</h3>
                    <p class="text-sm text-gray-600">راهنمای نگهداری گیاهان</p>
                </div>
            </div>

            @if($settings['phone'] ?? false)
                <div class="mt-8 text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700">
                        <span class="font-bold">📞 تماس با ما:</span> {{ $settings['phone'] }}
                    </p>
                    @if($settings['address'] ?? false)
                        <p class="text-gray-600 text-sm mt-1">
                            📍 {{ $settings['address'] }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection