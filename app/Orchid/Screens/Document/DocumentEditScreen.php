<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Document;

use App\Models\Document;
use App\Orchid\Layouts\Document\DocumentEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DocumentEditScreen extends Screen
{
    /** @var Document */
    public $document;

    public function query(Document $document): iterable
    {
        $document->load('category');

        return [
            'document' => $document,
        ];
    }

    public function name(): ?string
    {
        return $this->document->exists ? 'Редактирование документа' : 'Новый документ';
    }

    public function description(): ?string
    {
        return 'Загрузка PDF и привязка к разделу';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Удалить документ и все страницы?')
                ->method('remove')
                ->canSee($this->document->exists),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        $layouts = [
            Layout::block(DocumentEditLayout::class)
                ->title('Документ'),
        ];

        /*        if ($this->document->exists) {
                    $layouts[] = Layout::legend('document', [
                        Sight::make('conversion_status', 'Статус конвертации')
                            ->render(fn (Document $document) => $document->conversionStatusLabel()),

                        Sight::make('page_count', 'Страниц')
                            ->render(fn (Document $document) => (string) $document->page_count),

                        Sight::make('conversion_error', 'Ошибка')
                            ->render(fn (Document $document) => e($document->conversion_error ?: '—')),
                    ])->title('Конвертация PDF');
                }*/

        return $layouts;
    }

    public function save(Document $document, Request $request)
    {
        // Определяем базовые правила валидации для полей документа.
        // title: обязательное строковое поле длиной до 255 символов.
        // category_id: обязательное целое число, которое должно существовать в таблице categories.
        // sort_order: необязательное целое число, минимальное значение — 0.
        // is_active: необязательное булево значение.
        $rules = [
            'document.title' => 'required|string|max:255',
            'document.category_id' => 'required|integer|exists:categories,id',
            'document.sort_order' => 'nullable|integer|min:0',
            'document.is_active' => 'nullable|boolean',
        ];

        // Если документ ещё не существует в БД (новый документ) ИЛИ в запросе есть загруженный PDF‑файл,
        // добавляем правило валидации для файла: он обязателен, должен быть файлом формата PDF,
        // размер не должен превышать значение из конфига (по умолчанию — 5120 КБ).
        if (!$document->exists || $request->hasFile('pdf')) {
            $rules['pdf'] = 'required|file|mimes:pdf|max:' . config('kiosk.pdf_max_size_kb', 5120);
        }

        // Выполняем валидацию данных запроса по сформированным правилам.
        // При ошибке валидации Laravel автоматически перенаправит обратно с ошибками.
        $validated = $request->validate($rules);

        // Заполняем модель Document данными из валидированного запроса и сохраняем в БД.
        // Для sort_order используем значение из запроса, если оно есть, иначе — 0.
        // Для is_active явно преобразуем значение в булевый тип с помощью метода boolean().
        $document->fill([
            'title' => $validated['document']['title'],
            'category_id' => $validated['document']['category_id'],
            'sort_order' => $validated['document']['sort_order'] ?? 0,
            'is_active' => $request->boolean('document.is_active'),
        ])->save();

        // Если в запросе присутствует загруженный PDF‑файл, обрабатываем его.
        if ($request->hasFile('pdf')) {
            // Сохраняем загруженный файл в директорию, указанную методом storageDirectory() модели Document,
            // под именем id.pdf на диске public. Метод storeAs() возвращает путь к файлу.
            $request->file('pdf')->storeAs(
                $document->storageDirectory(),
                $document->id . '.pdf',
                'public'
            );
        } else {
            // Если файл не загружался, показываем информационное уведомление.
            Toast::info('Документ сохранён.');
        }
// Перенаправляем пользователя на страницу редактирования документа.
       // return redirect()->route('platform.kiosk.documents.edit', $document);
        return redirect()->route('platform.kiosk.documents');
    }

    public function remove(Document $document)
    {
        $document->pages()->delete();
        $document->deleteFiles();
        $document->delete();

        Toast::info('Документ удалён.');

        return redirect()->route('platform.kiosk.documents');
    }
}
