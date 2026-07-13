<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackSubmitted;
use App\Models\Category;
use App\Models\Document;
use App\Models\FeedbackMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Storage;

class KioskController extends Controller
{
    public function index(): View
    {
        return $this->categoryView(null);
    }

    /**
     * Отображает категорию или возвращает на главную страницу, если категория неактивна.
     *
     * @param Category|null $category
     * @return View|RedirectResponse
     */
    public function category(Category $category): View|RedirectResponse
        //   public function category(Category $category)
    {
        if (!$category->is_active) {
            return redirect()->route('kiosk.index');
        }

        return $this->categoryView($category);
    }

    /**
     * Отображает документ по указанному ID и странице или возвращает на главную страницу, если документ неактивен или конвертация не завершена.
     *
     * @param Document $document
     * @param int $page
     * @return View|RedirectResponse
     */
    public function document(Document $document, int $page = 1): View|RedirectResponse
     //   public function document(Document $document, int $page = 1)
        {
            // Проверяем, активен ли документ и завершена ли его конвертация.
            // Если документ неактивен или конвертация не завершена (статус не STATUS_DONE),
            // перенаправляем пользователя на главную страницу киоска.
            if (!$document->is_active ) {
                return redirect()->route('kiosk.index');
            }

            // Загружаем связанную модель категории для документа (eager loading),
            // чтобы избежать дополнительных запросов к БД при обращении к $document->category.
            $document->load('category');

            // Корректируем номер страницы: он не может быть меньше 1 и больше общего количества страниц.
            // Если $document->page_count не задан, используем 1 как значение по умолчанию.
       //     $page = max(1, min($page, $document->page_count ?: 1));

            // Получаем запись страницы документа с указанным номером.
            // Предполагаем, что у модели Document есть отношение pages(), возвращающее коллекцию страниц.

         //   $image = $document->pages()->where('page_number', $page)->first();

            // Если страница с таким номером не найдена (например, данные повреждены или страница удалена),
            // перенаправляем пользователя в категорию документа.
/*            if ($image === null) {
                return redirect()->route('kiosk.category', $document->category_id);
            }*/

            // Возвращаем представление для отображения страницы документа.
            // Передаем в шаблон: сам документ, текущий номер страницы, URL изображения,
            // ссылку для возврата в категорию и флаг, указывающий, нужно ли показывать кнопку «Назад».
/*            return view('kiosk.document', [
                'file' => 'РУК_Оценка_деятельности_персонала.pdf',
                'document' => $document,
                'page' => $page,
                // Формируем полный URL к изображению страницы, используя путь из БД и директорию storage.
                'imageUrl' => asset('storage/' . $image->image_path),
                // Генерируем маршрут для кнопки «Назад» — ведёт в категорию документа.
                'backUrl' => route('kiosk.category', $document->category_id),
                // Флаг для отображения кнопки «Назад» в представлении.
                'showBack' => true,
            ]);*/
            return view('kiosk.pdf-document', [
                'file' => asset('storage/documents/' . $document->id . '.pdf'),
                'document' => $document,
                'page' => $page,
                // Генерируем маршрут для кнопки «Назад» — ведёт в категорию документа.
                'backUrl' => route('kiosk.category', $document->category_id),
                // Флаг для отображения кнопки «Назад» в представлении.
                'showBack' => true,
            ]);

        }

    /**
     * Отображает страницу для отправки обратной связи.
     *
     * @return View
     */
    public function feedback(): View
    {
        return view('kiosk.feedback');
    }

    /**
     * Обрабатывает и сохраняет отправленную обратную связь, а затем отправляет уведомление по электронной почте.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitFeedback(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        $feedback = FeedbackMessage::create([
            'name' => $validated['name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'email_sent' => false,
            'is_read' => false,
        ]);

        $recipient = config('kiosk.feedback_mail_to');

        if ($recipient) {
            try {
                Mail::to($recipient)->send(new FeedbackSubmitted($feedback));
                $feedback->update(['email_sent' => true]);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return redirect()
            ->route('kiosk.feedback.thanks')
            ->with('feedback_sent', true);
    }

    /**
     * Отображает страницу благодарности за отправленную обратную связь.
     *
     * @return View|RedirectResponse
     */
    public function feedbackThanks(): View|RedirectResponse
        //   public function feedbackThanks()
    {
        if (!session('feedback_sent')) {
            return redirect()->route('kiosk.feedback');
        }

        return view('kiosk.feedback-thanks');
    }

    /**
     * Возвращает представление для отображения категории или всех категорий, если категория не указана.
     *
     * @param Category|null $category
     * @return View
     */
    protected function categoryView(?Category $category): View
    {
        // Если категория не передана (null), отображаем корневую страницу каталога.
        // Это может быть стартовый экран киоска с перечнем корневых категорий.
        if ($category === null) {
            $children = Category::query()
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();

            // На корневой странице документов нет, поэтому возвращаем пустую коллекцию.
            $documents = collect();

            // Возвращаем представление страницы категории.
            // Передаем null вместо категории).
            return view('kiosk.category', [
                'category' => null,
                'title' => 'Информация для посетителейZZZZZZ',
                'children' => $children,    // список корневых подкатегорий
                'documents' => $documents,  // пустой список документов
                'backUrl' => null,   // кнопки «Назад» нет, так как это начальный экран
            ]);
        }

        // Если категория передана, работаем с конкретной категорией.
        // Получаем активных детей текущей категории (прямые подкатегории).
        $children = $category->children()->where('is_active', true)->get();

        // Получаем активные документы текущей категории.
        $documents = $category->documents()
            ->where('is_active', true)
            //    ->where('conversion_status', Document::STATUS_DONE)
            //   ->where('page_count', '>', 0)
            ->get();

        // Формируем URL для кнопки «Назад».
        // Если у категории есть родитель, ссылка ведет к родительской категории.
        // Иначе (если это корневая категория) — на главную страницу киоска.
        $backUrl = $category->parent_id
            ? route('kiosk.category', $category->parent_id)
            : route('kiosk.index');

        // Возвращаем представление страницы категории с данными конкретной категории.
        return view('kiosk.category', [
            'category' => $category,        // текущая категория
            'title' => $category->title,    // заголовок страницы — название категории
            'children' => $children,        // список дочерних категорий
            'documents' => $documents,      // список документов категории
            'backUrl' => $backUrl,          // URL для кнопки возврата
        ]);
    }
}
