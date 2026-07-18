<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['site_name'] ?? 'گلفروشی پاساژ')</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700;900&display=swap');
        * { font-family: 'Vazirmatn', sans-serif; }
        
        .mobile-menu { display: none; }
        .mobile-menu.active { display: block; }
        .menu-transition { transition: all 0.3s ease-in-out; }
        .scientific-card {
            background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e9 100%);
            border-right: 4px solid #2d6a4f;
        }
        .info-box { transition: transform 0.2s; }
        .info-box:hover { transform: translateY(-2px); }
        
        /* استایل‌های گالری */
        .gallery-item { cursor: pointer; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- ==================== منو ==================== -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-green-700">🌿</span>
                    <span class="text-xl font-bold text-gray-800 mr-2">{{ $settings['shop_name'] ?? 'گلفروشی' }}</span>
                    <span class="text-sm text-gray-500 hidden sm:inline">| {{ $settings['site_description'] ?? 'انواع گیاهان آپارتمانی و فضای باز' }}</span>
                </div>
                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-green-700 border-b-2 border-green-700 pb-1 font-medium">صفحه اصلی</a>
                    <a href="#" class="text-gray-600 hover:text-green-700 transition pb-1">گیاهان</a>
                    <a href="#" class="text-gray-600 hover:text-green-700 transition pb-1">دسته‌بندی</a>
                    <a href="#" class="text-gray-600 hover:text-green-700 transition pb-1">راهنما</a>
                    <a href="#" class="text-gray-600 hover:text-green-700 transition pb-1">تماس با ما</a>
                </div>
                <div class="md:hidden">
                    <button id="menuToggle" class="text-gray-700 hover:text-green-700 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobileMenu" class="mobile-menu md:hidden bg-white border-t-2 border-green-100 shadow-lg">
            <div class="px-4 py-3 space-y-3">
                <a href="{{ route('home') }}" class="block text-green-700 font-bold py-2 border-b border-gray-100">
                    <i class="fas fa-home ml-2"></i>صفحه اصلی
                </a>
                <a href="#" class="block text-gray-600 hover:text-green-700 py-2 border-b border-gray-100">
                    <i class="fas fa-seedling ml-2"></i>گیاهان
                </a>
                <a href="#" class="block text-gray-600 hover:text-green-700 py-2 border-b border-gray-100">
                    <i class="fas fa-tags ml-2"></i>دسته‌بندی
                </a>
                <a href="#" class="block text-gray-600 hover:text-green-700 py-2 border-b border-gray-100">
                    <i class="fas fa-book ml-2"></i>راهنما
                </a>
                <a href="#" class="block text-gray-600 hover:text-green-700 py-2">
                    <i class="fas fa-phone ml-2"></i>تماس با ما
                </a>
            </div>
        </div>
    </nav>

    <!-- ==================== محتوای اصلی ==================== -->
    <main class="min-h-screen bg-gradient-to-b from-green-50 to-white py-8">
        @yield('content')
    </main>

    <!-- ==================== فوتر (داینامیک) ==================== -->
    <footer class="bg-green-700 text-white text-center py-4 px-2 text-sm">
        <p>🌱 {{ $settings['shop_name'] ?? 'گلفروشی' }} - {{ $settings['footer_text'] ?? 'همه‌ی گیاهان با بهترین کیفیت' }}</p>
        <p class="text-green-300 text-xs mt-1">
            تلفن: {{ $settings['phone'] ?? '۰۲۱-۱۲۳۴۵۶۷۸' }} | 
            آدرس: {{ $settings['address'] ?? 'مشگین شهر، خیابان امام، پاساژ جواهری' }}
        </p>
        @if($settings['copyright_text'] ?? false)
            <p class="text-green-200 text-xs mt-1">{{ $settings['copyright_text'] }}</p>
        @endif
    </footer>

    <!-- ==================== اسکریپت منو ==================== -->
    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    </script>
    
    @stack('scripts')
</body>
</html>