@extends('layouts.app')

@section('title', $plant->name)

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- ==================== هدر با تصویر ==================== -->
        <div class="relative h-96 bg-green-100">
             @if($plant->featured_image)
                <img src="{{ asset('storage/' . $plant->featured_image) }}" 
                    alt="{{ $plant->name }}" 
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                    <span>تصویری برای این گیاه ثبت نشده است</span>
                </div>
            @endif
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

        <!-- ==================== قیمت و وضعیت ==================== -->
        <div class="flex flex-wrap justify-between items-center p-6">
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
                    <span class="text-lg text-gray-600">{{ $currency }}</span>
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

        <!-- ==================== اطلاعات سریع ==================== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-gray-50 ">
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

        <!-- ==================== گالری تصاویر ==================== -->
        @if($plant->gallery_images && is_array($plant->gallery_images) && count($plant->gallery_images) > 0)
        <div class="p-6 ">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-images text-green-600 ml-2"></i>
                گالری تصاویر
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="galleryGrid">
                @foreach($plant->gallery_images as $key => $image)
                    <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition group cursor-pointer gallery-item" onclick="openLightbox({{ $key }})">
                        <img src="{{ asset('storage/' . $image) }}" 
                            alt="{{ $plant->name }} - {{ $key+1 }}" 
                            class="w-full h-48 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <button onclick="openGallery()" class="text-green-600 hover:text-green-800 font-medium text-sm transition border border-green-600 px-6 py-2 rounded-lg hover:bg-green-50">
                    <i class="fas fa-images ml-1"></i>
                    مشاهده همه تصاویر
                </button>
            </div>
        </div>
        @endif

        <!-- ==================== اطلاعات مراقبت ==================== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-white ">
            @if($plant->water)
                <div class="text-center"><div class="text-3xl">💧</div><div class="font-bold text-sm mt-1 text-gray-700">آبیاری</div><div class="text-sm text-gray-600">{{ $plant->water }}</div></div>
            @endif
            @if($plant->light)
                <div class="text-center"><div class="text-3xl">☀️</div><div class="font-bold text-sm mt-1 text-gray-700">نور</div><div class="text-sm text-gray-600">{{ $plant->light }}</div></div>
            @endif
            @if($plant->temperature)
                <div class="text-center"><div class="text-3xl">🌡️</div><div class="font-bold text-sm mt-1 text-gray-700">دما</div><div class="text-sm text-gray-600">{{ $plant->temperature }}</div></div>
            @endif
            @if($plant->humidity)
                <div class="text-center"><div class="text-3xl">💨</div><div class="font-bold text-sm mt-1 text-gray-700">رطوبت</div><div class="text-sm text-gray-600">{{ $plant->humidity }}</div></div>
            @endif
        </div>

        <!-- ==================== توضیحات کامل ==================== -->
        <div class="p-6 space-y-4 ">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-info-circle text-green-600 ml-2"></i>
                معرفی
            </h2>
            @if($plant->short_description)
                <p class="text-gray-700 leading-relaxed">{{ $plant->short_description }}</p>
            @endif

            @if($plant->description)
                <h2 class="text-2xl font-bold text-gray-800 mt-6 flex items-center">
                    <i class="fas fa-hand-holding-heart text-green-600 ml-2"></i>
                    نحوه‌ی نگهداری
                </h2>
                <div class="space-y-3 text-gray-700">
                    {!! $plant->description !!}
                </div>
            @endif

            <!-- اطلاعات تکمیلی -->
            <div class="grid grid-cols-2 gap-4 mt-6 p-4 bg-gray-50 rounded-lg">
                @if($plant->fertilizer)
                    <div><span class="text-sm text-gray-500">کوددهی</span><div class="font-bold">{{ $plant->fertilizer }}</div></div>
                @endif
                @if($plant->repotting)
                    <div><span class="text-sm text-gray-500">تعویض گلدان</span><div class="font-bold">{{ $plant->repotting }}</div></div>
                @endif
                @if($plant->pruning)
                    <div><span class="text-sm text-gray-500">هرس کردن</span><div class="font-bold">{{ $plant->pruning }}</div></div>
                @endif
                @if($plant->propagation)
                    <div><span class="text-sm text-gray-500">تکثیر</span><div class="font-bold">{{ $plant->propagation }}</div></div>
                @endif
            </div>
        </div>

        <!-- ==================== دسته‌بندی زیست‌شناسی ==================== -->
        <div class="p-6 ">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-dna text-green-600 ml-2"></i>
                دسته‌بندی زیست‌شناسی
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    @if($plant->scientific_name)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">نام علمی</span><span class="font-bold">{{ $plant->scientific_name }}</span></div></div>
                    @endif
                    @if($plant->family)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">خانواده</span><span class="font-bold">{{ $plant->family }}</span></div></div>
                    @endif
                    @if($plant->genus)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">سرده</span><span class="font-bold">{{ $plant->genus }}</span></div></div>
                    @endif
                </div>
                <div class="space-y-3">
                    @if($plant->order_name)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">راسته</span><span class="font-bold">{{ $plant->order_name }}</span></div></div>
                    @endif
                    @if($plant->origin)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">منشأ</span><span class="font-bold">{{ $plant->origin }}</span></div></div>
                    @endif
                    @if($plant->class_name)
                        <div class="scientific-card p-4 rounded-lg"><div class="flex justify-between"><span class="text-sm text-gray-600">کلاس</span><span class="font-bold">{{ $plant->class_name }}</span></div></div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ==================== QR Code ==================== -->
        @if($plant->qr_code_path)
        <div class="bg-gray-100 p-6 text-center">
            <p class="text-sm text-gray-600 mb-2">برای اطلاعات بیشتر اسکن کنید</p>
            <img src="{{ asset('storage/' . $plant->qr_code_path) }}" 
                 alt="QR Code" 
                 class="mx-auto w-32 h-32">
            <p class="text-xs text-gray-400 mt-2">{{ route('plants.show', $plant->slug) }}</p>
        </div>
        @endif

    </div>
</div>

<!-- ==================== لایت‌باکس ==================== -->
<div id="lightbox" class="fixed inset-0 bg-black/90 z-[999] hidden items-center justify-center p-4" onclick="closeLightbox()">
    <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
        <img id="lightboxImage" src="" alt="تصویر بزرگ" class="w-full h-auto max-h-[90vh] object-contain rounded-lg">
        <button onclick="closeLightbox()" class="absolute top-2 left-2 text-white text-4xl hover:text-gray-300 transition">
            <i class="fas fa-times"></i>
        </button>
        <button onclick="prevLightboxImage()" class="absolute top-1/2 right-4 -translate-y-1/2 text-white text-4xl hover:text-gray-300 transition">
            <i class="fas fa-chevron-right"></i>
        </button>
        <button onclick="nextLightboxImage()" class="absolute top-1/2 left-4 -translate-y-1/2 text-white text-4xl hover:text-gray-300 transition">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm bg-black/50 px-4 py-2 rounded-full">
            <span id="lightboxCounter">
                ۱ از {{ is_array($plant->gallery_images) ? count($plant->gallery_images) : 0 }}
            </span>
        </div>
    </div>
</div>

<!-- ==================== گالری کامل ==================== -->
<div id="galleryModal" class="fixed inset-0 bg-white z-[999] hidden overflow-y-auto">
    <div class="sticky top-0 bg-white shadow-lg p-4 flex justify-between items-center z-10">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-images text-green-600 ml-2"></i>
            گالری تصاویر
        </h2>
        <button onclick="closeGallery()" class="text-gray-600 hover:text-gray-800 text-2xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="max-w-6xl mx-auto p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="galleryModalGrid">
        <!-- تصاویر توسط جاوااسکریپت پر می‌شوند -->
    </div>
</div>

<!-- ==================== اسکریپت‌های گالری ==================== -->
@push('scripts')
<script>
    // لیست تصاویر گالری از دیتابیس (یک بار تعریف شده)
    const galleryImages = [
        @if($plant->gallery_images && is_array($plant->gallery_images))
            @foreach($plant->gallery_images as $image)
                { src: '{{ asset('storage/' . $image) }}', alt: '{{ $plant->name }}' },
            @endforeach
        @endif
    ];

    let currentLightboxIndex = 0;

    // باز کردن لایت‌باکس
    window.openLightbox = function(index) {
        if (galleryImages.length === 0) return;
        currentLightboxIndex = index;
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightboxImage');
        img.src = galleryImages[index].src;
        document.getElementById('lightboxCounter').textContent = `${index + 1} از ${galleryImages.length}`;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    // بستن لایت‌باکس
    window.closeLightbox = function() {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // تصویر قبلی و بعدی
    window.prevLightboxImage = function() {
        if (galleryImages.length === 0) return;
        currentLightboxIndex = (currentLightboxIndex - 1 + galleryImages.length) % galleryImages.length;
        const img = document.getElementById('lightboxImage');
        img.src = galleryImages[currentLightboxIndex].src;
        document.getElementById('lightboxCounter').textContent = `${currentLightboxIndex + 1} از ${galleryImages.length}`;
    }

    window.nextLightboxImage = function() {
        if (galleryImages.length === 0) return;
        currentLightboxIndex = (currentLightboxIndex + 1) % galleryImages.length;
        const img = document.getElementById('lightboxImage');
        img.src = galleryImages[currentLightboxIndex].src;
        document.getElementById('lightboxCounter').textContent = `${currentLightboxIndex + 1} از ${galleryImages.length}`;
    }

    // باز کردن گالری کامل
    window.openGallery = function() {
        if (galleryImages.length === 0) return;
        const modal = document.getElementById('galleryModal');
        const grid = document.getElementById('galleryModalGrid');
        
        grid.innerHTML = '';
        galleryImages.forEach((image, index) => {
            const div = document.createElement('div');
            div.className = 'relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition group cursor-pointer';
            div.innerHTML = `
                <img src="${image.src}" alt="${image.alt}" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition duration-300 flex items-center justify-center" onclick="openLightbox(${index}); closeGallery();">
                    <i class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition"></i>
                </div>
            `;
            grid.appendChild(div);
        });
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // بستن گالری کامل
    window.closeGallery = function() {
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // کیبورد: کلیدهای چپ/راست و Escape
    document.addEventListener('keydown', function(e) {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextLightboxImage();
            if (e.key === 'ArrowLeft') prevLightboxImage();
            if (e.key === 'Escape') closeLightbox();
        }
        const gallery = document.getElementById('galleryModal');
        if (!gallery.classList.contains('hidden') && e.key === 'Escape') {
            closeGallery();
        }
    });
</script>
@endpush
@endsection