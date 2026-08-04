<!-- ==================== منو ==================== -->
<nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-green-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- لوگو -->
            <div class="flex items-center">
                <span class="text-2xl font-bold text-green-700">🌿</span>
                <span class="text-xl font-bold text-gray-800 mr-2">{{ $settings['shop_name'] ?? 'گلفروشی' }}</span>
                <span class="text-sm text-gray-500 hidden sm:inline">| {{ $settings['site_description'] ?? 'انواع گیاهان آپارتمانی و فضای باز' }}</span>
            </div>

            <!-- منوی دسکتاپ -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-green-700 border-b-2 border-green-700 pb-1 font-medium' : 'text-gray-600 hover:text-green-700 transition pb-1' }}">
                    صفحه اصلی
                </a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-green-700 border-b-2 border-green-700 pb-1 font-medium' : 'text-gray-600 hover:text-green-700 transition pb-1' }}">
                    درباره ما
                </a>
                <a href="{{ route('shops.index') }}" class="text-gray-600 hover:text-green-700 transition pb-1">
                    فروشگاه‌ها
                </a>                
                <a href="{{ route('shop.request.create') }}" class="block text-gray-600 hover:text-green-700 py-2">
                    <i class="fas fa-store ml-2"></i>ثبت‌نام فروشگاه
                </a>

            </div>
            

            <!-- دکمه همبرگری -->
            <div class="md:hidden">
                <button id="menuToggle" class="text-gray-700 hover:text-green-700 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- منوی موبایل -->
    <div id="mobileMenu" class="mobile-menu md:hidden bg-white border-t-2 border-green-100 shadow-lg">
        <div class="px-4 py-3 space-y-3">
            <a href="{{ route('home') }}" class="block {{ request()->routeIs('home') ? 'text-green-700 font-bold' : 'text-gray-600 hover:text-green-700' }} py-2 border-b border-gray-100">
                <i class="fas fa-home ml-2"></i>صفحه اصلی
            </a>
            <a href="{{ route('about') }}" class="block {{ request()->routeIs('about') ? 'text-green-700 font-bold' : 'text-gray-600 hover:text-green-700' }} py-2">
                <i class="fas fa-info-circle ml-2"></i>درباره ما
            </a>
            <a href="{{ route('shops.index') }}" class="block text-gray-600 hover:text-green-700 py-2 border-b border-gray-100">
                <i class="fas fa-store ml-2"></i>فروشگاه‌ها
            </a>
            <a href="{{ route('shop.request.create') }}" class="block text-gray-600 hover:text-green-700 py-2">
                <i class="fas fa-store ml-2"></i>ثبت‌نام فروشگاه
            </a>
        </div>
    </div>
</nav>