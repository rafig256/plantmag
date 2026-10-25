<?php

namespace App\Filament\Pages;

use App\Models\Shop;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MyShop extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.my-shop';

    protected static ?string $title = 'فروشگاه من';

    protected static ?string $navigationLabel = 'فروشگاه من';

    protected static string|\BackedEnum|null $navigationIcon =
        \Filament\Support\Icons\Heroicon::OutlinedBuildingStorefront;

    public ?array $data = [];

    protected function getShop(): Shop
    {
        $shop = Auth::user()?->ownedShop;

        abort_unless($shop, 404);

        return $shop;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->ownedShop()->exists() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(
            $this->getShop()->only([
                'name',
                'phone',
                'address',
                'about_text',
                'footer_text',
                'banner_image',
                'banner_alt',
                'meta_description',
            ])
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات اصلی فروشگاه')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('نام فروشگاه')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('تلفن')
                            ->maxLength(20),

                        TextInput::make('address')
                            ->label('آدرس'),
                    ]),

                Section::make('محتوای فروشگاه')
                    ->columns(2)
                    ->schema([
                        Textarea::make('about_text')
                            ->label('درباره فروشگاه')
                            ->rows(5)
                            ->columnSpanFull(),

                        Textarea::make('footer_text')
                            ->label('متن فوتر')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('banner_image')
                            ->label('تصویر بنر')
                            ->image()
                            ->directory('shops/banners'),

                        TextInput::make('banner_alt')
                            ->label('متن جایگزین تصویر'),

                        TextInput::make('meta_description')
                            ->label('توضیحات متا')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('ذخیره تغییرات')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $shop = $this->getShop();

        $data = $this->form->getState();

        $shop->fill([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'about_text' => $data['about_text'] ?? null,
            'footer_text' => $data['footer_text'] ?? null,
            'banner_image' => $data['banner_image'] ?? null,
            'banner_alt' => $data['banner_alt'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ])->save();

        Notification::make()
            ->title('تغییرات فروشگاه ذخیره شد')
            ->success()
            ->send();

        $this->form->fill($shop->only([
            'name',
            'phone',
            'address',
            'about_text',
            'footer_text',
            'banner_image',
            'banner_alt',
            'meta_description',
        ]));
    }
}
