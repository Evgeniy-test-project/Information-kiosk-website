<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'categories' => Category::with('parent.parent.parent.parent.parent')
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Разделы';
    }

    public function description(): ?string
    {
        return 'Структура разделов и подразделов инфомата';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.kiosk.categories.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            CategoryListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        $category = Category::findOrFail($request->get('id'));

        if ($category->children()->exists()) {
            Toast::error('Нельзя удалить раздел с подразделами.');

            return;
        }

        if ($category->documents()->exists()) {
            Toast::error('Нельзя удалить раздел с документами.');

            return;
        }

        $category->delete();

        Toast::info('Раздел удалён.');
    }
}
