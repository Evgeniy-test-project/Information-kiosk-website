<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    public function fields(): array
    {
        $categoryId = $this->query->get('category.id');
        $excludeId = $categoryId ? (int) $categoryId : null;

        return [
            Input::make('category.title')
                ->title('Название')
                ->required()
                ->max(255),

            Select::make('category.parent_id')
                ->title('Родительский раздел')
                ->options(Category::optionsForSelect($excludeId))
                ->empty('— Корневой раздел —', ''),

            Input::make('category.sort_order')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->min(0),

            Switcher::make('category.is_active')
                ->title('Активен')
                ->sendTrueOrFalse(),
        ];
    }
}
