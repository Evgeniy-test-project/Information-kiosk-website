<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Document;

use App\Models\Category;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;

class DocumentEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('document.title')
                ->title('Название')
                ->required()
                ->max(255),

            Select::make('document.category_id')
                ->title('Раздел')
                ->options(Category::optionsForSelect())
                ->required(),

            Input::make('document.sort_order')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->min(0),

            Switcher::make('document.is_active')
                ->title('Активен')
                ->sendTrueOrFalse(),

            Input::make('pdf')
                ->type('file')
                ->title('PDF-файл')
                ->accept('.pdf,application/pdf')
                ->help('Максимальный размер: 5 МБ. При замене файла страницы будут пересозданы.'),
        ];
    }
}
