@extends('layouts.app')

@section('title', 'درباره ' . $shop->name)

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-6">🌿 درباره {{ $shop->name }}</h1>
        
        <div class="prose prose-green max-w-none">
            @if($shop->about_text)
                {!! $shop->about_text !!}
            @else
                <p class="text-gray-600">توصیفی برای این فروشگاه ثبت نشده است.</p>
            @endif
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                @if($shop->phone)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-3xl mb-2">📞</div>
                        <h3 class="font-bold text-gray-800">تلفن</h3>
                        <p class="text-gray-600">{{ $shop->phone }}</p>
                    </div>
                @endif
                @if($shop->address)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-3xl mb-2">📍</div>
                        <h3 class="font-bold text-gray-800">آدرس</h3>
                        <p class="text-gray-600">{{ $shop->address }}</p>
                    </div>
                @endif
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl mb-2">🌱</div>
                    <h3 class="font-bold text-gray-800">تعداد گیاهان</h3>
                    <p class="text-gray-600">{{ $shop->plants()->count() }} گونه</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection