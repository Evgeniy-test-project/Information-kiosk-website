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
    {
        if (!$category->is_active) {
            return redirect()->route('kiosk.index');
        }

        return $this->categoryView($category);
    }

    /**
     * Отображает документ по указанному ID и странице или возвращает на главную страницу, если документ неактивен.
     **/

    public function document(Document $document, int $page = 1): View|RedirectResponse
        //   public function document(Document $document, int $page = 1)
    {
        // Проверяем, активен ли документ.
        // Если документ неактивен,
        // перенаправляем пользователя на главную страницу киоска.
        if (!$document->is_active) {
            return redirect()->route('kiosk.index');
        }

        return view('kiosk.pdf-document', [
            'file' => asset('storage/documents/' . $document->id . '.pdf'),
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
                'title' => 'Информация для посетителей',
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
