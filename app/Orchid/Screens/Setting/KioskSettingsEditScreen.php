<?php

namespace App\Orchid\Screens\Setting;

use App\Models\KioskSetting;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class KioskSettingsEditScreen extends Screen
{

    public function query(KioskSetting $KioskSetting): iterable
    {
        return [
            'KioskSetting' => $KioskSetting,
        ];
    }

    public function name(): ?string
    {
        return 'KioskSettingsEditScreen';
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
            Layout::block(
                Layout::rows([
                    Input::make('KioskSetting.key')
                        ->title('Параметр')
                        ->required()
                        ->max(255),
                    Input::make('KioskSetting.value')
                        ->title('Значение')
                        ->required()
                        ->max(255),
                ]))->title('xx')->description('zzzzzzzzzzz xxxxxxxxxxx')
        ];
    }

    /**
     * Обработка сохранения
     */
    public function save(KioskSetting $KioskSetting, Request $request)
    {
        // Извлекаем данные из запроса
        $key = $request->input('KioskSetting.key');
        $value = $request->input('KioskSetting.value');

        // Обновляем модель KioskSetting
        if ($KioskSetting->update([
            'key' => $key,
            'value' => $value,
        ])) {
            Toast::success('Настройки успешно сохранены.');
        } else {
            Toast::error('Произошла ошибка при сохранении настроек.');
        }

        return redirect()->route('platform.KioskSetting.list');

    }



}
