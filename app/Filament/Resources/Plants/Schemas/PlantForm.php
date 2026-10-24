<?php

namespace App\Filament\Resources\Plants\Schemas;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Services\PlantAiService;
use App\Models\Shop;
use Filament\Facades\Filament;

class PlantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('plant-tabs')
                    ->tabs([
                        
                        // ==================== 🌱 تب اطلاعات پایه ====================
                        Tab::make('اطلاعات پایه')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('name')
                                    ->label('نام فارسی گیاه')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: بابا آدم')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, callable $set, ?string $state) {
                                        if (filled($get('slug'))) {
                                            return;
                                        }

                                        $set('slug', str($state)->slug());
                                    })
                                    ->suffixAction(
                                        Action::make('aiSuggest')
                                            ->label('جستجو با هوش مصنوعی')
                                            ->icon('heroicon-o-sparkles')
                                            ->action(function (Get $get, Set $set) {
                                                $name = (string) $get('name');

                                                if (blank($name)) {
                                                    Notification::make()
                                                        ->title('نام گیاه را وارد کنید')
                                                        ->danger()
                                                        ->send();

                                                    return;
                                                }

                                                try {
                                                    $result = app(PlantAiService::class)->suggest($name);
                                                    $data = $result['data'] ?? [];

                                                    foreach ([
                                                        'scientific_name',
                                                        'family',
                                                        'order_name',
                                                        'leaf_color',
                                                        'max_height'
                                                        ,'type'
                                                        ,'growth_type',
                                                        'flowering_season',
                                                        ] as $field) {
                                                        if (array_key_exists($field, $data) && filled($data[$field])) {
                                                            $set($field, $data[$field]);
                                                        }
                                                    }

                                                    $source = ($result['source'] ?? null) === 'database' ? 'پایگاه داده' : 'هوش مصنوعی';

                                                    Notification::make()
                                                        ->title('اطلاعات با موفقیت تکمیل شد')
                                                        ->body("منبع: {$source}")
                                                        ->success()
                                                        ->send();
                                                } catch (\Throwable $e) {
                                                    Notification::make()
                                                        ->title('خطا در دریافت اطلاعات')
                                                        ->body('امکان دریافت اطلاعات وجود ندارد. لطفاً دوباره تلاش کنید.')
                                                        ->danger()
                                                        ->send();
                                                }
                                            })
                                    )
                                    ->columnSpan(2),
                                Select::make('shop_id')
                                    ->label('فروشگاه')
                                    ->relationship('shop', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->visible(fn () => auth()->user()->role === 'admin')
                                    ->default(fn () => auth()->user()->shop_id),
                                
                                TextInput::make('scientific_name')
                                    ->label('نام علمی')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: Alocasia amazonica'),
                                
                                TextInput::make('family')
                                    ->label('خانواده')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: Araceae'),
                                
                                TextInput::make('genus')
                                    ->label('سرده')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: Alocasia'),
                                
                                TextInput::make('order_name')
                                    ->label('راسته')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: Alismatales'),
                                
                                TextInput::make('class_name')
                                    ->label('کلاس')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: Liliopsida'),
                                
                                TextInput::make('origin')
                                    ->label('منشأ')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: جنوب شرقی آسیا'),
                                
                                Select::make('type')
                                    ->label('نوع گیاه')
                                    ->options([
                                        'علیف' => 'علیف (گیاهی)',
                                        'درختچه' => 'درختچه',
                                        'کاکتوس' => 'کاکتوس',
                                        'گلدار' => 'گلدار',
                                        'ساکولنت' => 'ساکولنت',
                                    ])
                                    ->placeholder('نوع گیاه را انتخاب کنید'),
                            ])
                            ->columns(2),
                        
                        // ==================== 🌿 تب ویژگی‌ها و نگهداری ====================
                        Tab::make('ویژگی‌ها و نگهداری')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                TextInput::make('max_height')
                                    ->label('حداکثر ارتفاع')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: ۱۰۰ سانتیمتر')
                                    ->suffix('سانتیمتر'),
                                
                                Select::make('growth_type')
                                    ->label('نوع رشد')
                                    ->options([
                                        'چندساله' => 'چندساله',
                                        'یکساله' => 'یکساله',
                                        'دوساله' => 'دوساله',
                                    ])
                                    ->placeholder('نوع رشد را انتخاب کنید'),
                                
                                Select::make('flowering_season')
                                    ->label('فصل گلدهی')
                                    ->options([
                                        'بهار' => 'بهار',
                                        'تابستان' => 'تابستان',
                                        'پاییز' => 'پاییز',
                                        'زمستان' => 'زمستان',
                                        'همیشه' => 'همیشه',
                                    ])
                                    ->placeholder('فصل گلدهی را انتخاب کنید'),
                                
                                Select::make('leaf_color')
                                    ->label('رنگ برگ')
                                    ->options([
                                        'سبز تیره' => 'سبز تیره',
                                        'سبز روشن' => 'سبز روشن',
                                        'ارغوانی' => 'ارغوانی',
                                        'ابلق' => 'ابلق',
                                        'طلایی' => 'طلایی',
                                    ])
                                    ->placeholder('رنگ برگ را انتخاب کنید'),
                                
                                Select::make('flower_color')
                                    ->label('رنگ گل')
                                    ->options([
                                        'سفید' => 'سفید',
                                        'صورتی' => 'صورتی',
                                        'زرد' => 'زرد',
                                        'نارنجی' => 'نارنجی',
                                        'قرمز' => 'قرمز',
                                        'آبی' => 'آبی',
                                    ])
                                    ->placeholder('رنگ گل را انتخاب کنید'),
                                
                                Select::make('difficulty')
                                    ->label('سطح نگهداری')
                                    ->options([
                                        'آسان' => 'آسان',
                                        'متوسط' => 'متوسط',
                                        'سخت' => 'سخت',
                                    ])
                                    ->placeholder('سطح نگهداری را انتخاب کنید'),
                                
                                TextInput::make('water')
                                    ->label('آبیاری')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: هفته‌ای ۲ بار')
                                    ->suffix('💧'),
                                
                                TextInput::make('light')
                                    ->label('نور')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: نور غیرمستقیم')
                                    ->suffix('☀️'),
                                
                                TextInput::make('temperature')
                                    ->label('دما')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: ۱۸-۳۰ درجه')
                                    ->suffix('🌡️'),
                                
                                TextInput::make('humidity')
                                    ->label('رطوبت')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: ۶۰-۸۰٪')
                                    ->suffix('💨'),
                                
                                TextInput::make('soil')
                                    ->label('خاک')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: خاک برگ + پرلیت')
                                    ->suffix('🧪'),
                                
                                TextInput::make('fertilizer')
                                    ->label('کود')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: کود مایع هر ماه')
                                    ->suffix('🌱'),
                                
                                TextInput::make('repotting')
                                    ->label('تعویض گلدان')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: هر ۲ سال یکبار')
                                    ->suffix('🪴'),
                                
                                TextInput::make('pruning')
                                    ->label('هرس')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: هرس برگ‌های خشک')
                                    ->suffix('✂️'),
                                
                                TextInput::make('propagation')
                                    ->label('تکثیر')
                                    ->maxLength(255)
                                    ->placeholder('مثلاً: تقسیم بوته')
                                    ->suffix('🌱'),
                                
                                Select::make('toxicity')
                                    ->label('سمیت')
                                    ->options([
                                        'سمی برای حیوانات' => 'سمی برای حیوانات',
                                        'غیرسمی' => 'غیرسمی',
                                        'تحریک‌کننده پوست' => 'تحریک‌کننده پوست',
                                        'سمی برای انسان' => 'سمی برای انسان',
                                    ])
                                    ->placeholder('وضعیت سمیت را انتخاب کنید'),
                            ])
                            ->columns(2),
                        
                        // ==================== 📝 تب محتوا ====================
                        Tab::make('محتوا')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Textarea::make('short_description')
                                    ->label('توضیحات کوتاه')
                                    ->maxLength(255)
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->placeholder('خلاصه‌ای از گیاه را وارد کنید...'),
                                
                                RichEditor::make('description')
                                    ->label('توضیحات کامل')
                                    ->columnSpanFull()
                                    ->placeholder('توضیحات کامل گیاه را وارد کنید...')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'h2',
                                        'codeBlock',
                                    ]),
                            ])
                            ->columns(1),
                        
                        // ==================== 💰 تب فروش ====================
                        Tab::make('فروش')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextInput::make('min_price')
                                    ->label('حداقل قیمت')
                                    ->numeric()
                                    ->minValue(0)
                                    ->integer()
                                    ->prefix('تومان')
                                    ->placeholder('مثلاً: 100000')
                                    ->maxValue(99999999),
                                
                                TextInput::make('max_price')
                                    ->label('حداکثر قیمت')
                                    ->numeric()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('تومان')
                                    ->placeholder('مثلاً: 500000')
                                    ->maxValue(99999999),
                                
                                Toggle::make('is_available')
                                    ->label('موجود')
                                    ->default(true)
                                    ->onIcon('heroicon-o-check-circle')
                                    ->offIcon('heroicon-o-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ])
                            ->columns(2),
                        
                        // ==================== 📷 تب تصاویر ====================
                        Tab::make('تصاویر')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('تصویر شاخص')
                                    ->image()
                                    ->directory('plants')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->columnSpanFull()
                                    ->placeholder('تصویر اصلی گیاه را آپلود کنید')
                                    ->disk('public')
                                    ->visibility('public'),
                                
                                FileUpload::make('gallery_images')
                                    ->label('گالری تصاویر')
                                    ->image()
                                    ->directory('plants/gallery')
                                    ->multiple()
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->columnSpanFull()
                                    ->placeholder('تصاویر بیشتر را آپلود کنید')
                                    ->disk('public')
                                    ->visibility('public')
                                    ,
                            ])
                            ->columns(1),
                        
                        // ==================== 🔍 تب سئو ====================
                        Tab::make('سئو')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('slug')
                                    ->label('اسلاگ (لینک دوستانه)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('این اسلاگ به‌صورت خودکار از نام گیاه تولید می‌شود، اما می‌توانید آن را تغییر دهید.')
                                    ->placeholder('مثلاً: alocasia-amazonica')
                                    ->columnSpanFull(),
                                
                                TextInput::make('meta_title')
                                    ->label('عنوان متا')
                                    ->maxLength(255)
                                    ->columnSpanFull()
                                    ->placeholder('عنوانی که در نتایج جستجو نمایش داده می‌شود'),
                                
                                Textarea::make('meta_description')
                                    ->label('توضیحات متا')
                                    ->maxLength(255)
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->placeholder('توضیح مختصری برای نمایش در نتایج جستجو'),
                                
                                TextInput::make('meta_keywords')
                                    ->label('کلمات کلیدی متا')
                                    ->maxLength(255)
                                    ->columnSpanFull()
                                    ->helperText('کلمات کلیدی را با ویرگول از هم جدا کنید')
                                    ->placeholder('مثلاً: بابا آدم، گیاه آپارتمانی، Alocasia'),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpanFull()
                    ->activeTab(1), // اولین تب به‌صورت پیش‌فرض فعال باشد
            ]);
    }
}