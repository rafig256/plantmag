@extends('layouts.app')

@section('title', 'ثبت‌نام و درخواست فروشگاه')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- هدر فرم -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                🌱 ثبت‌نام و درخواست فروشگاه
            </h1>
            <p class="text-green-100 text-sm mt-1">
                با ثبت درخواست، فروشگاه خود را راه‌اندازی کنید و گیاهان خود را به مشتریان معرفی کنید.
            </p>
        </div>

        <!-- فرم -->
        <form action="{{ route('shop.request.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- اطلاعات فروشگاه -->
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b pb-3">
                    <span class="text-2xl">🏪</span> اطلاعات فروشگاه
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                    <div class="md:col-span-2">
                        <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-1">نام فروشگاه</label>
                        <input type="text" name="shop_name" id="shop_name" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               value="{{ old('shop_name') }}" 
                               placeholder="مثلاً: گلفروشی پاساژ"
                               required>
                        @error('shop_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="shop_slug" class="block text-sm font-medium text-gray-700 mb-1">آدرس فروشگاه</label>
                        <div class="flex items-stretch">
                            <span class="bg-gray-100 border border-r-0 border-gray-300 rounded-r-none rounded-md px-4 py-2.5 text-sm text-gray-500 flex items-center">
                                {{ request()->getHost() }}/gol-
                            </span>
                            <input type="text" name="shop_slug" id="shop_slug" 
                                   class="flex-1 rounded-l-none rounded-md border-gray-300 
                                          focus:border-green-400 
                                          focus:ring-4 focus:ring-green-200/60 
                                          focus:shadow-md 
                                          focus:outline-none 
                                          transition duration-200 
                                          placeholder-gray-400"
                                   value="{{ old('shop_slug') }}" 
                                   placeholder="pasaj"
                                   required>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">فقط حروف انگلیسی، اعداد و خط تیره (مثلاً: pasaj)</p>
                        @error('shop_slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">📞 تلفن</label>
                        <input type="text" name="phone" id="phone" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               value="{{ old('phone') }}" 
                               placeholder="۰۲۱-۱۲۳۴۵۶۷۸">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">📍 آدرس</label>
                        <input type="text" name="address" id="address" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               value="{{ old('address') }}" 
                               placeholder="مشگین شهر، خیابان امام، پاساژ جواهری">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="about_text" class="block text-sm font-medium text-gray-700 mb-1">درباره فروشگاه</label>
                        <textarea name="about_text" id="about_text" rows="3" 
                                  class="w-full rounded-md border-gray-300 
                                         focus:border-green-400 
                                         focus:ring-4 focus:ring-green-200/60 
                                         focus:shadow-md 
                                         focus:outline-none 
                                         transition duration-200 
                                         placeholder-gray-400"
                                  placeholder="توضیحات مختصری درباره فروشگاه خود بنویسید...">{{ old('about_text') }}</textarea>
                        @error('about_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- اطلاعات کاربر -->
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b pb-3">
                    <span class="text-2xl">👤</span> اطلاعات مدیر فروشگاه
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                    <div class="md:col-span-2">
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">نام کامل</label>
                        <input type="text" name="user_name" id="user_name" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               value="{{ old('user_name') }}" 
                               placeholder="علی رضایی"
                               required>
                        @error('user_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                        <input type="email" name="user_email" id="user_email" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               value="{{ old('user_email') }}" 
                               placeholder="info@example.com"
                               required>
                        @error('user_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
                        <input type="password" name="user_password" id="user_password" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               placeholder="••••••••"
                               required>
                        @error('user_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تکرار رمز عبور</label>
                        <input type="password" name="user_password_confirmation" id="user_password_confirmation" 
                               class="w-full rounded-md border-gray-300 
                                      focus:border-green-400 
                                      focus:ring-4 focus:ring-green-200/60 
                                      focus:shadow-md 
                                      focus:outline-none 
                                      transition duration-200 
                                      placeholder-gray-400"
                               placeholder="••••••••"
                               required>
                    </div>
                </div>
            </div>

            <!-- انتخاب پکیج -->
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b pb-3">
                    <span class="text-2xl">📦</span> انتخاب پکیج
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    @foreach($packages as $package)
                        <label class="relative block border-2 rounded-xl p-5 cursor-pointer transition-all duration-300 
                                      hover:shadow-lg hover:scale-[1.02]
                                      {{ old('package_id') == $package->id ? 'border-green-500 bg-green-50/70 shadow-lg' : 'border-gray-200 hover:border-green-300' }}">
                            <input type="radio" name="package_id" value="{{ $package->id }}" 
                                   class="absolute opacity-0 w-0 h-0"
                                   {{ old('package_id') == $package->id ? 'checked' : '' }}>
                            
                            <div class="text-center">
                                <div class="text-3xl mb-2">
                                    @if($package->slug == 'free') 🎁
                                    @elseif($package->slug == 'starter') 🌱
                                    @elseif($package->slug == 'pro') 🚀
                                    @elseif($package->slug == 'premium') 👑
                                    @else 📦
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-800">{{ $package->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                                <p class="text-sm text-gray-600 mt-2">
                                    <span class="font-bold text-green-700">{{ $package->plant_count }}</span> گیاه
                                </p>
                                @if($package->price)
                                    <p class="text-lg font-bold text-green-600 mt-2">{{ number_format($package->price) }} تومان</p>
                                @else
                                    <p class="text-sm text-gray-400 mt-2">رایگان</p>
                                @endif
                                
                                <!-- نشان انتخاب -->
                                <div class="mt-3 {{ old('package_id') == $package->id ? 'block' : 'hidden' }} package-check">
                                    <span class="inline-block bg-green-500 text-white text-xs px-3 py-1 rounded-full">
                                        ✅ انتخاب شده
                                    </span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('package_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- دکمه ثبت -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 
                               hover:from-green-700 hover:to-green-800 
                               text-white font-bold py-4 px-6 rounded-xl 
                               transition-all duration-300 
                               shadow-lg hover:shadow-2xl 
                               hover:scale-[1.01] 
                               flex items-center justify-center gap-3 text-lg">
                    <span>📤</span>
                    ثبت درخواست
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input[name="package_id"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.package-check').forEach(function(el) {
                el.classList.add('hidden');
            });
            document.querySelectorAll('input[name="package_id"]').forEach(function(r) {
                r.closest('label').classList.remove('border-green-500', 'bg-green-50/70', 'shadow-lg');
                r.closest('label').classList.add('border-gray-200');
            });
            
            const label = this.closest('label');
            label.classList.add('border-green-500', 'bg-green-50/70', 'shadow-lg');
            label.classList.remove('border-gray-200');
            label.querySelector('.package-check').classList.remove('hidden');
        });
    });
</script>
@endpush
@endsection