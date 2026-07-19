<?php

namespace App\Orchid\Screens\Setting;

use App\Models\Setting;
use App\Orchid\Layouts\Setting\SettingListLayout;

use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Group;


class SettingListScreen extends Screen
{

    public function query(): iterable
    {
        return [
            'setting' => Setting::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Настройки';
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('создать')->modal('CreateSetting')->method('create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            SettingListLayout::class,
            Layout::modal('CreateSetting', Layout::rows([
                Group::make([
                    Input::make('key')->required()->title('Параметр'),
                    Input::make('value')->required()->title('Значение'),
                ]),
            ]))->title('test')->applyButton('Сохранить')
        ];
    }

    public function create(Request $request): void
    {
        Setting::create($request->except('_token'));

        //Setting::create($request->merge([])->except('_token'));
        Toast::info('test');
    }
}
