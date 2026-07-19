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
    <!-- swiper slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

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
    @include('partials.menu')

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

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>