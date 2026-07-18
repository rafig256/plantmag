@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'گلفروشی پاساژ')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <!-- هدر صفحه اصلی -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-green-700">🌿 {{ $settings['shop_name'] ?? 'گلفروشی' }}</h1>
        <p class="text-gray-600 mt-2">{{ $settings['site_description'] ?? 'انواع گیاهان آپارتمانی و فضای باز' }}</p>
    </div>

    <!-- شبکه گیاهان -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($plants as $plant)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                <!-- تصویر -->
                <a href="{{ route('plants.show', $plant->slug) }}">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        @if($plant->featured_image)
                            <img src="{{ asset('storage/' . $plant->featured_image) }}" 
                                 alt="{{ $plant->name }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>بدون تصویر</span>
                            </div>
                        @endif
                    </div>
                </a>

                <!-- اطلاعات -->
                <div class="p-4">
                    <a href="{{ route('plants.show', $plant->slug) }}" class="hover:underline">
                        <h3 class="text-lg font-bold text-gray-800">{{ $plant->name }}</h3>
                    </a>
                    
                    @if($plant->scientific_name)
                        <p class="text-sm text-gray-500 italic">{{ $plant->scientific_name }}</p>
                    @endif

                    <!-- قیمت -->
                    <div class="mt-2">
                        @if($plant->min_price && $plant->max_price)
                            <span class="text-green-700 font-bold">
                                {{ number_format($plant->min_price) }} - {{ number_format($plant->max_price) }}
                            </span>
                        @elseif($plant->min_price)
                            <span class="text-green-700 font-bold">از {{ number_format($plant->min_price) }}</span>
                        @else
                            <span class="text-gray-400 text-sm">قیمت نامشخص</span>
                        @endif
                        <span class="text-sm text-gray-500">{{ $settings['currency'] ?? 'تومان' }}</span>
                    </div>

                    <!-- موجودی -->
                    <div class="mt-2">
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $plant->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $plant->is_available ? '✅ موجود' : '❌ ناموجود' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">هیچ گیاهی برای نمایش وجود ندارد</p>
            </div>
        @endforelse
    </div>

    <!-- صفحه‌بندی -->
    <div class="mt-8">
        {{ $plants->links() }}
    </div>

</div>
@endsection