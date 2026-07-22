<?php

namespace App\Orchid\Screens\Setting;

use App\Models\KioskSetting;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class KioskSettingsListScreen extends Screen
{

    public function query(): iterable
    {
        return [
            'KioskSetting' => KioskSetting::all(),
        ];
    }


    public function name(): ?string
    {
        return 'KioskSettingsListScreen';
    }


    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.KioskSetting.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('KioskSetting', [
                TD::make('key', 'параметр'),
                TD::make('value', 'значение'),

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (KioskSetting $KioskSetting) {

                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list([
                                Link::make(__('Edit'))
                                    ->route('platform.KioskSettings.edit', $KioskSetting)
                                    ->icon('bs.pencil'),

                                // Встроенная кнопка удаления Orchid
                                Button::make('Удалить')
                                    ->method('remove')
                                    ->canSee(true)
                                    ->icon('trash')
                                    ->confirm('Вы действительно хотите удалить эту запись?')
                                    ->parameters(['id' => $KioskSetting->id]),
                            ]);
                    }),
            ])];
    }

    public function remove(Request $request)
    {
        $id = $request->input('id');

        if (!$id) {
            Toast::error('Не указан ID настройки.');
            return redirect()->back();
        }

        $KioskSetting = KioskSetting::find($id);

        if ($KioskSetting) {
            $KioskSetting->delete();
            Toast::info('Настройка успешно удалена.');
        } else {
            Toast::error('Настройка с таким ID не найдена.');
        }

        return redirect()->route('platform.KioskSetting.list');
    }

}
