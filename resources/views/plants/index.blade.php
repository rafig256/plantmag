@extends('layouts.app')

@section('title', $plant->name)

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- هدر با تصویر -->
        <div class="relative h-96 bg-green-100">
            <img src="{{ asset('storage/' . $plant->featured_image) }}" 
                 alt="{{ $plant->name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div class="flex items-end justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-4xl font-bold text-white">🌿 {{ $plant->name }}</h1>
                        @if($plant->scientific_name)
                            <p class="text-green-200 text-xl">{{ $plant->scientific_name }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        @if($plant->difficulty)
                            <span class="bg-yellow-500/90 text-white px-4 py-2 rounded-full text-sm font-bold backdrop-blur-sm">
                                ⭐ {{ $plant->difficulty }}
                            </span>
                        @endif
                        @if($plant->toxicity)
                            <span class="bg-red-500/90 text-white px-4 py-2 rounded-full text-sm font-bold backdrop-blur-sm">
                                ⚠️ {{ $plant->toxicity }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- قیمت و وضعیت -->
        <div class="flex flex-wrap justify-between items-center p-6 border-b">
            <div class="flex items-center gap-4">
                <div>
                    @if($plant->min_price && $plant->max_price)
                        <span class="text-3xl font-bold text-green-700">
                            {{ number_format($plant->min_price) }}-{{ number_format($plant->max_price) }}
                        </span>
                    @elseif($plant->min_price)
                        <span class="text-3xl font-bold text-green-700">
                            از {{ number_format($plant->min_price) }}
                        </span>
                    @endif
                    <span class="text-lg text-gray-600">تومان</span>
                </div>
                <span class="bg-green-100 text-green-800 text-sm px-4 py-1.5 rounded-full font-bold">
                    {{ $plant->is_available ? '✅ موجود' : '❌ ناموجود' }}
                </span>
            </div>
            <div class="flex gap-2 mt-2 sm:mt-0">
                @if($plant->type)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">🪴 {{ $plant->type }}</span>
                @endif
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">🌱 آپارتمانی</span>
            </div>
        </div>

        <!-- اطلاعات سریع -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-gray-50 border-b">
            <div class="text-center info-box">
                <div class="text-3xl">🌱</div>
                <div class="font-bold text-sm mt-1 text-gray-700">نوع گیاه</div>
                <div class="text-sm text-gray-600">{{ $plant->type ?? 'نامشخص' }}</div>
            </div>
            <div class="text-center info-box">
                <div class="text-3xl">⏳</div>
                <div class="font-bold text-sm mt-1 text-gray-700">طول عمر</div>
                <div class="text-sm text-gray-600">{{ $plant->growth_type ?? 'نامشخص' }}</div>
            </div>
            <div class="text-center info-box">
                <div class="text-3xl">📏</div>
                <div class="font-bold text-sm mt-1 text-gray-700">ارتفاع</div>
                <div class="text-sm text-gray-600">{{ $plant->max_height ?? 'نامشخص' }}</div>
            </div>
            <div class="text-center info-box">
                <div class="text-3xl">🌸</div>
                <div class="font-bold text-sm mt-1 text-gray-700">گلدهی</div>
                <div class="text-sm text-gray-600">{{ $plant->flowering_season ?? 'نامشخص' }}</div>
            </div>
        </div>

        <!-- ادامه اطلاعات مراقبت، توضیحات، زیست‌شناسی و QR کد -->
        <!-- ... (بقیه کد مشابه فایل alocasia.html اما با داده‌های داینامیک) ... -->

    </div>
</div>
@endsection