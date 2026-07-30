<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Инфомат')</title>
    @stack('styles')
</head>

<body class="h-screen flex flex-col bg-gray-100">

<!-- Шапка -->
<header class="bg-white shadow p-4 flex items-center justify-between fixed top-0 left-0 right-0">
    {{--            показываем кнопки НАЗАД и НА ГЛАВНУЮ--}}
    <div>
        @if(!empty($showBack) && !empty($backUrl))
            <a href="{{ $backUrl }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 text-[25px]">Назад</a>
        @endif
        <a href="{{ route('kiosk.index') }}"
           class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 text-[25px]">На главную</a>
    </div>
    {{--заголовок раздела--}}
    <div class="flex items-center">
        <h1 class="text-3xl font-bold ml-4">{{ $pageTitle ?? 'Информация для посетителей' }}</h1>
    </div>

    <div class="text-gray-600 text-xl">
        <span id="currentTime" class="mr-4"></span>
        <span id="currentDate"></span>
    </div>

</header>
@if(!empty($file))
    {{--показываем документ--}}
    <div class="flex-1">
        @yield('content')
    </div>
@else
    {{--показываем блок кнопок--}}
    <div class="flex-1 pt-8">
        <main class="pt-15">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
@endif

{{--Закрепленный футер --}}
{{--берем данные из конфигурации--}}
@php
    $setting = \App\Models\KioskSetting::where('key', 'Футер')->first();
    $setValue = $setting ? $setting->value : '';
@endphp
<footer class="bg-gray-200 p-4 text-center">
    <p class="text-gray-600">{{$setValue}}</p>
</footer>

<script>
    window.KIOSK_IDLE_TIMEOUT = {{ (int) config('infomat.idle_timeout_seconds', 120) }};
</script>

@stack('scripts')
</body>
</html>
