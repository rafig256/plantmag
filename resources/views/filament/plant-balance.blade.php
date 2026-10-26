@php
    $user = auth()->user();
    $shop = $user?->shop;
@endphp

@if ($user && $user->role !== 'admin' && $shop)
    <div class="px-3">
        <div class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-800 dark:border-amber-700 dark:bg-amber-950 dark:text-amber-300">
            <x-filament::icon
                icon="heroicon-o-sparkles"
                class="h-5 w-5 shrink-0"
            />
            <span class="inline-block">
                ظرفیت مجاز: {{ number_format($shop->plant_balance) }} گیاه
            </span>
        </div>
    </div>
@endif