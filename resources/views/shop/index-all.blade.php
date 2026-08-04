@extends('layouts.app')

@section('title', 'لیست فروشگاه‌ها')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <!-- ==================== هدر صفحه ==================== -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-green-700">🏪 لیست فروشگاه‌ها</h1>
        <p class="text-gray-600 mt-2">فروشگاه‌های عضو شده در سیستم را مشاهده کنید.</p>
    </div>

    <!-- ==================== شبکه فروشگاه‌ها ==================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($shops as $shop)
            <a href="{{ route('shop.index', $shop->slug) }}" class="block group">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden hover:scale-[1.02]">
                    
                    <!-- بنر فروشگاه -->
                    <div class="h-40 bg-gray-200 overflow-hidden relative">
                        @if($shop->banner_image && file_exists(public_path('storage/' . $shop->banner_image)))
                            <img src="{{ asset('storage/' . $shop->banner_image) }}" 
                                 alt="{{ $shop->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200">
                                <span class="text-6xl">🌿</span>
                            </div>
                        @endif
                        
                        <!-- نشان فعال -->
                        @if($shop->is_active)
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                فعال
                            </span>
                        @endif
                    </div>

                    <!-- اطلاعات فروشگاه -->
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-800 group-hover:text-green-700 transition">
                            {{ $shop->name }}
                        </h2>
                        
                        @if($shop->about_text)
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                {{ Str::limit(strip_tags($shop->about_text), 80) }}
                            </p>
                        @endif

                        <div class="mt-3 flex items-center justify-between text-sm text-gray-500">
                            <span>
                                <i class="fas fa-seedling ml-1"></i>
                                {{ $shop->plants()->count() }} گیاه
                            </span>
                            <span class="text-green-600 group-hover:underline">
                                مشاهده فروشگاه
                                <i class="fas fa-arrow-left mr-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">هیچ فروشگاهی برای نمایش وجود ندارد</p>
            </div>
        @endforelse
    </div>

    <!-- صفحه‌بندی -->
    <div class="mt-8">
        {{ $shops->links() }}
    </div>

</div>
@endsection