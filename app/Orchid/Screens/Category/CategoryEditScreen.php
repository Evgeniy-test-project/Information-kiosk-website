<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    /** @var Category */
    public $category;

    public function query(Category $category): iterable
    {
        return [
            'category' => $category,
        ];
    }

    public function name(): ?string
    {
        return $this->category->exists ? 'Редактирование раздела' : 'Новый раздел';
    }

    public function description(): ?string
    {
        return 'Название, родительский раздел и порядок отображения';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Удалить раздел?')
                ->method('remove')
                ->canSee($this->category->exists),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(CategoryEditLayout::class)
                ->title('Раздел'),
        ];
    }

    public function save(Category $category, Request $request)
    {
        $data = $request->validate([
            'category.title' => 'required|string|max:255',
            'category.parent_id' => 'nullable|integer|exists:categories,id',
            'category.sort_order' => 'nullable|integer|min:0',
            'category.is_active' => 'nullable|boolean',
        ])['category'];

        $parentId = $data['parent_id'] ?: null;

        if ($category->exists && $parentId !== null) {
            $parent = Category::find($parentId);

            if ($parent !== null && ($parent->id === $category->id || $parent->isDescendantOf($category))) {
                Toast::error('Нельзя выбрать этот родительский раздел.');

                return back()->withInput();
            }
        }

        $category->fill([
            'title' => $data['title'],
            'parent_id' => $parentId,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('category.is_active'),
        ])->save();

        Toast::info('Раздел сохранён.');

        return redirect()->route('platform.kiosk.categories');
    }

    public function remove(Category $category)
    {
        if ($category->children()->exists()) {
            Toast::error('Нельзя удалить раздел с подразделами.');

            return back();
        }

        if ($category->documents()->exists()) {
            Toast::error('Нельзя удалить раздел с документами.');

            return back();
        }

        $category->delete();

        Toast::info('Раздел удалён.');

        return redirect()->route('platform.kiosk.categories');
    }
}
