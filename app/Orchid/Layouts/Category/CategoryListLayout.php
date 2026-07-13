<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    public $target = 'categories';

    public function columns(): array
    {
        return [
            TD::make('title', 'Название')
                ->sort()
                ->render(function (Category $category) {
                    return e($category->pathLabel());
                }),

            TD::make('sort_order', 'Порядок')
                ->sort()
                ->width('100px'),

            TD::make('is_active', 'Активен')
                ->render(function (Category $category) {
                    return $category->is_active ? 'Да' : 'Нет';
                })
                ->width('100px'),

            TD::make('updated_at', 'Изменён')
                ->render(function (Category $category) {
                    return $category->updated_at->format('d.m.Y H:i');
                })
                ->width('150px'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Category $category) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.kiosk.categories.edit', $category)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Удалить раздел?')
                                ->method('remove', ['id' => $category->id]),
                        ]);
                }),
        ];
    }
}
