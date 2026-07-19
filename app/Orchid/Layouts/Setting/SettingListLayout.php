<?php

namespace App\Orchid\Layouts\Setting;

use App\Models\Setting;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SettingListLayout extends Table
{

    protected $target = 'setting';


    protected function columns(): iterable
    {
        return [
            TD::make('key', 'параметр'),
            TD::make('value', 'значение'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Setting $setting) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make('Редактировать')
                            ->route('platform.setting.edit', $setting)
                            ->icon('pencil'),

                    ])),
        ];
    }
}
