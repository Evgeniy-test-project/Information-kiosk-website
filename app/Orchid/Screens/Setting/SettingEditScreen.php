<?php

namespace App\Orchid\Screens\Setting;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use App\Models\Setting;

class SettingEditScreen extends Screen
{
    public $setting;

    public function query(Setting $setting): iterable
    {

        return [
            'setting' => $setting,
        ];
    }

    public function name(): ?string
    {
        return 'SettingEditScreen';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('setting.key')
                    ->title('Параметр')
                    ->required()
                    ->max(255),
                Input::make('setting.volume')
                    ->title('Значение')
                    ->required()
                    ->max(255),
            ])
        ];
    }
}
