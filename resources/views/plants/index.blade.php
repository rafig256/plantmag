@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'گلفروشی پاساژ')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <!-- ==================== بنر تصویری ==================== -->
    <div class="w-full h-64 md:h-80 lg:h-96 rounded-2xl overflow-hidden shadow-lg mb-12">
        <img src="{{ asset('images/banner.jpg') }}" 
             alt="بنر گلفروشی" 
             class="w-full h-full object-cover">
    </div>

    <!-- ==================== اسلایدر گیاهان ==================== -->
    @if($sliderPlants->count() > 0)
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">🌱 گیاهان</h2>
            <div class="swiper plant-slider relative overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($sliderPlants as $plant)
                        <div class="swiper-slide p-2">
                            @include('components.plant-card', ['plant' => $plant])
                        </div>
                    @endforeach
                </div>

                <!-- دکمه‌های اسلایدر -->
                <button @click="prev()" 
                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-green-700 p-3 rounded-full shadow-lg transition z-10">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button @click="next()" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-green-700 p-3 rounded-full shadow-lg transition z-10">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- ==================== اسلایدر محبوب‌ترین گیاهان ==================== -->
    @if($popularPlants->count() > 0)
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🔥 محبوب‌ترین گیاهان</h2>
        <div class="swiper plant-slider relative overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($popularPlants as $plant)
                    <div class="swiper-slide p-2">
                        @include('components.plant-card', ['plant' => $plant])
                    </div>
                @endforeach
            </div>

            <!-- دکمه‌های اسلایدر -->
            <button @click="prev()" 
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-green-700 p-3 rounded-full shadow-lg transition z-10">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button @click="next()" 
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-green-700 p-3 rounded-full shadow-lg transition z-10">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
@endif

    <!-- ==================== شبکه گیاهان (صفحه‌بندی شده) ==================== -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🌿 همه گیاهان</h2>
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

                    <!-- نمایش سه ویژگی (نوع، نور، آبیاری) هر کدام در یک سطر -->
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
                        <span class="text-sm text-gray-500">{{ $settings['currency'] ?? 'تومان' }}</span>
                    </div>

                    <!-- موجودی و QR Code -->
                    <div class="mt-3 flex items-center justify-between">
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $plant->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $plant->is_available ? '✅ موجود' : '❌ ناموجود' }}
                        </span>
                        @if($plant->qr_code_path)
                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/' . $plant->qr_code_path) }}" 
                                   download="qr-{{ $plant->slug }}.svg" 
                                   class="text-xs text-green-600 hover:text-green-800 hover:underline"
                                   title="دانلود QR Code">
                                    <i class="fas fa-download ml-1"></i>
                                    QR
                                </a>
                                <img src="{{ asset('storage/' . $plant->qr_code_path) }}" 
                                     alt="QR Code" 
                                     class="w-8 h-8 cursor-pointer hover:scale-110 transition"
                                     onclick="window.open('{{ route('plants.show', $plant->slug) }}', '_blank')">
                            </div>
                        @endif
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
@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.plant-slider').forEach(function (slider) {

        new Swiper(slider, {

            slidesPerView: 1,
            direction: 'rtl',

            spaceBetween: 20,

            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev'),
            },

            breakpoints: {

                640: {
                    slidesPerView: 2,
                },

                1024: {
                    slidesPerView: 4,
                }

            }

        });

    });

});

</script>
@endpush