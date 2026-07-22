<?php

namespace App\Orchid\Screens\Setting;

use App\Models\KioskSetting;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class KioskSettingsCreateScreen extends Screen
{

    public function query(KioskSetting $KioskSetting): iterable
    {
        return [
            'KioskSetting' => $KioskSetting,
        ];
    }


    public function name(): ?string
    {
        return 'KioskSettingsCreateScreen';
    }


    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('create'),
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

    public function create(Request $request)
    {
        // Извлекаем данные из запроса
        $key = $request->input('KioskSetting.key');
        $value = $request->input('KioskSetting.value');

        // Создаем новый экземпляр модели KioskSetting и сохраняем его
        $KioskSetting = new KioskSetting();
        $KioskSetting->key = $key;
        $KioskSetting->value = $value;

        if ($KioskSetting->save()) {
            Toast::success('Настройка успешно создана.');
        } else {
            Toast::error('Произошла ошибка при создании настройки.');
        }

        // Перенаправляем пользователя на страницу просмотра всех настроек
        return redirect()->route('platform.KioskSetting.list');
    }

}
