<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Document;

use App\Models\Document;
use App\Orchid\Layouts\Document\DocumentListLayout;
use App\Services\PdfConverterService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class DocumentListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'documents' => Document::with('category.parent.parent.parent.parent')
                ->orderBy('sort_order')
                ->orderBy('title')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Документы';
    }

    public function description(): ?string
    {
        return 'PDF-документы для отображения на инфомате';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.kiosk.documents.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            DocumentListLayout::class,
        ];
    }
}
