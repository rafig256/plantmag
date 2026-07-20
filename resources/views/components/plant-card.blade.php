<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
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
    <div class="p-4">
        <a href="{{ route('plants.show', $plant->slug) }}" class="hover:underline">
            <h3 class="text-lg font-bold text-gray-800">{{ $plant->name }}</h3>
        </a>
        @if($plant->scientific_name)
            <p class="text-sm text-gray-500 italic">{{ $plant->scientific_name }}</p>
        @endif

        <!-- سه ویژگی در سه سطر مجزا -->
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

        <!-- قیمت (منطق یکسان) -->
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

        <!-- موجودی -->
        <div class="mt-2">
            <span class="inline-block px-2 py-1 text-xs rounded-full {{ $plant->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $plant->is_available ? '✅ موجود' : '❌ ناموجود' }}
            </span>
        </div>
    </div>
</div>