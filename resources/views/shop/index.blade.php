@extends('layouts.app')

@section('title', $shop->name)

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <!-- ==================== هدر فروشگاه ==================== -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 rounded-2xl overflow-hidden shadow-lg mb-8">
        @if($shop->banner_image && file_exists(public_path('storage/' . $shop->banner_image)))
            <img src="{{ asset('storage/' . $shop->banner_image) }}" 
                 alt="{{ $shop->banner_alt ?? $shop->name }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-green-600 to-green-700">
                <h1 class="text-4xl md:text-5xl font-bold text-white">🌿 {{ $shop->name }}</h1>
            </div>
        @endif
    </div>

    <!-- ==================== اطلاعات فروشگاه ==================== -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $shop->name }}</h1>
                @if($shop->about_text)
                    <p class="text-gray-600 mt-2">{{ Str::limit($shop->about_text, 200) }}</p>
                @endif
            </div>
            <div class="text-right">
                @if($shop->phone)
                    <p class="text-gray-600"><i class="fas fa-phone ml-2"></i> {{ $shop->phone }}</p>
                @endif
                @if($shop->address)
                    <p class="text-gray-600 text-sm"><i class="fas fa-map-marker-alt ml-2"></i> {{ $shop->address }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- ==================== شبکه گیاهان فروشگاه ==================== -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🌱 گیاهان {{ $shop->name }}</h2>
    
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

                    <!-- سه ویژگی -->
                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                        @if($plant->type)
                            <span class="flex items-center gap-2"><i class="fas fa-seedling text-green-500"></i> {{ $plant->type }}</span>
                        @endif
                        @if($plant->light)
                            <span class="flex items-center gap-2"><i class="fas fa-sun text-yellow-500"></i> {{ $plant->light }}</span>
                        @endif
                        @if($plant->water)
                            <span class="flex items-center gap-2"><i class="fas fa-tint text-blue-500"></i> {{ $plant->water }}</span>
                        @endif
                    </div>

                    <!-- قیمت -->
                    <div class="mt-2">
                        @if($plant->min_price && $plant->max_price)
                            @if($plant->min_price == $plant->max_price)
                                <span class="text-green-700 font-bold">{{ number_format($plant->min_price) }}</span>
                            @else
                                <span class="text-green-700 font-bold">
                                    {{ number_format($plant->min_price) }} - {{ number_format($plant->max_price) }}
                                </span>
                            @endif
                        @elseif($plant->min_price)
                            <span class="text-green-700 font-bold">از {{ number_format($plant->min_price) }}</span>
                        @else
                            <span class="text-gray-400 text-sm">قیمت نامشخص</span>
                        @endif
                        <span class="text-sm text-gray-500">{{ $shop->currency ?? 'تومان' }}</span>
                    </div>

                    <!-- موجودی -->
                    <div class="mt-3">
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