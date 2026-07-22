<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Document;

use App\Models\Document;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DocumentListLayout extends Table
{
    public $target = 'documents';

    public function columns(): array
    {
        return [
            TD::make('title', 'Название')
                ->sort(),

            TD::make('category_id', 'Раздел')
                ->render(fn (Document $document) => e($document->category ? $document->category->pathLabel() : '—')),

/*            TD::make('page_count', 'Страниц')
                ->width('100px'),

     TD::make('conversion_status', 'Конвертация')
                ->render(fn (Document $document) => $document->conversionStatusLabel()),*/

            TD::make('is_active', 'Активен')
                ->render(fn (Document $document) => $document->is_active ? 'Да' : 'Нет')
                ->width('100px'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Document $document) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.kiosk.documents.edit', $document)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Удалить документ и все страницы?')
                                ->method('remove', ['id' => $document->id]),
                        ])),

        ];
    }
}
