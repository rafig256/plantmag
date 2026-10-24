<?php

namespace App\Services;

use App\Models\Plant;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PlantAiService
{
    /**
     * ابتدا جست‌وجو در دیتابیس؛ در صورت نبودن، درخواست از هوش مصنوعی.
     */
    public function suggest(string $plantName): array
    {
        $plantName = trim($plantName);

        if ($plantName === '') {
            throw new RuntimeException('نام گیاه وارد نشده است.');
        }

        // 1. جست‌وجوی نام فارسی یا نام علمی در دیتابیس
        $plant = Plant::query()
            ->where('name', $plantName)
            ->orWhere('scientific_name', $plantName)
            ->first();

        if ($plant) {
            return [
                'source' => 'database',
                'data' => [
                    'scientific_name' => $plant->scientific_name,
                    'family' => $plant->family,
                    'order_name' => $plant->order_name,
                    'leaf_color' => $plant->leaf_color,
                    'max_height' => $plant->max_height,
                ],
            ];
        }

        // 2. اگر گیاه در دیتابیس نبود، از Kilo اطلاعات می‌گیریم
        return [
            'source' => 'ai',
            'data' => $this->fetchFromKilo($plantName),
        ];
    }

    /**
     * دریافت اطلاعات گیاه از Kilo Gateway.
     */
    private function fetchFromKilo(string $plantName): array
    {
        $api_url = env('KILO_API_URL','https://api.kilo.ai/api/gateway/chat/completions');
        $model = config('services.kilo.model');
        $apiKey = config('services.kilo.api_key');

        $request = Http::withOptions([
            'proxy' => 'http://127.0.0.1:18080',
        ])->acceptJson()
            ->timeout((int) config('services.kilo.timeout', 45));

        if (filled($apiKey)) {
            $request = $request->withToken($apiKey);
        }

        $response = $request->post(
            $api_url,
            [
                'model' => $model,
                'stream' => false,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => <<<'PROMPT'
You provide preliminary plant information for a plant shop.
Return only valid JSON. Do not use Markdown or code fences.
Use these exact keys:
scientific_name, family, order, leaf_color,
max_height_indoor_m, max_height_natural_m, type, growth_type, flowering_season.
Use numbers for heights and null if unknown.
The order field must be the botanical taxonomic order,
not the plant's growth habit.
For select-like fields use exactly one of these allowed values or null:
type: علیف, درختچه, کاکتوس, گلدار, ساکولنت
growth_type: چندساله, یکساله, دوساله
flowering_season: بهار, تابستان, پاییز, زمستان, همیشه

PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => "Plant name: {$plantName}. Return the information in Persian where appropriate.",
                    ],
                ],
            ]
        );

        $response->throw();

        $content = $response->json('choices.0.message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new RuntimeException(
                'پاسخ معتبری از سرویس هوش مصنوعی دریافت نشد.'
            );
        }

        $data = json_decode(
            trim($content),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (! is_array($data)) {
            throw new RuntimeException(
                'ساختار پاسخ هوش مصنوعی معتبر نیست.'
            );
        }

        // تبدیل ارتفاع از متر به سانتی‌متر، مطابق فیلد فعلی فرم
        $height = $data['max_height_indoor_m'] ?? null;

        return [
            'scientific_name' => $data['scientific_name'] ?? null,
            'family' => $data['family'] ?? null,
            'order_name' => $data['order'] ?? null,
            'leaf_color' => $data['leaf_color'] ?? null,
            'max_height' => is_numeric($height)
                ? (string) ($height * 100)
                : null,
            'type' => $data['order'] ?? null,
            'growth_type' => $data['growth_type'] ?? null,
            'flowering_season' =>$data['flowering_season'] ?? null,
        ];
    }
}
