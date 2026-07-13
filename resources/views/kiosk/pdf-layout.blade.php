<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Инфомат')</title>
    {{--    <link rel="stylesheet" href="{{ asset('css/kiosk.css') }}">--}}
    @stack('styles')
</head>
{{--<body class="kiosk-body">--}}
<body class="h-screen flex flex-col bg-gray-100">

<!-- Шапка -->
<header class="bg-white shadow p-4 flex items-center justify-between fixed top-0 left-0 right-0">
    {{--            показываем кнопки НАЗАД и НА ГЛАВНУЮ--}}
    <div class="">
        @if(!empty($showBack) && !empty($backUrl))
            <a href="{{ $backUrl }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 text-[25px]">Назад</a>
        @endif
        <a href="{{ route('kiosk.index') }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 text-[25px]">На главную</a>
    </div>

    <div class="flex items-center">
        <h1 class="text-3xl font-bold ml-4">{{ $pageTitle ?? 'Информация для посетителей9999999' }}</h1>
    </div>

    <div class="text-gray-600 text-xl">
        <span id="currentTime" class="mr-4">00:00</span>
        <span id="currentDate"></span>
    </div>

</header>

<div class="flex-1 ">
{{--    <main class="py-15">--}}
{{--        <div class="max-w-7xl mx-auto">--}}
            @yield('content')
{{--        </div>--}}
{{--    </main>--}}
</div>

<!-- Закрепленный футер -->
<footer class="bg-gray-200 p-4 text-center">
    <p class="text-gray-600">© ГАУЗ СО Детская городская поликлиника № 13, г. Екатеринбург.</p>
</footer>
<!-- Скрипт для обновления времени -->
<script>
    setInterval(() => {
        const now = new Date();
        // Форматирование времени
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('currentTime').textContent = `${hours}:${minutes}`;

        // Форматирование даты
        const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        const months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        const day = days[now.getDay()];
        const month = months[now.getMonth()];
        const date = now.getDate();

        document.getElementById('currentDate').textContent = `${date} ${month}, ${day}`;

    }, 1000);
</script>
<script>
    window.KIOSK_IDLE_TIMEOUT = {{ (int) config('infomat.idle_timeout_seconds', 120) }};
</script>

@stack('scripts')
</body>
</html>

