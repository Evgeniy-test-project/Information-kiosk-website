<p>Поступило новое обращение с инфомата.</p>

<ul>
    <li><strong>Дата:</strong> {{ $feedback->created_at->format('d.m.Y H:i') }}</li>
 {{--   <li><strong>Имя:</strong> {{ $feedback->name ?: '—' }}</li>
    <li><strong>Телефон:</strong> {{ $feedback->phone ?: '—' }}</li>--}}
</ul>

<p><strong>Текст:</strong></p>
<p>{{ $feedback->message }}</p>
