@extends('kiosk.layout')

@section('title', 'Спасибо')

@php
    $pageTitle = 'Обратная связь';
    $showBack = false;
    $backUrl = null;
@endphp

@section('content')
    <div class="flex flex-col items-center justify-center max-w-md mx-auto p-8 bg-white rounded-xl shadow-lg space-y-4">
        <!-- Заголовок -->
        <h2 class="text-3xl font-bold text-gray-900 leading-tight">
            Спасибо!
        </h2>

        <!-- Текст сообщения -->
        <p class="text-lg text-gray-600 text-center">
            Ваше обращение принято.
        </p>

        <!-- Кнопка -->
        <a
            href="{{ route('kiosk.index') }}"
            class="inline-flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
        >
            На главную
        </a>
    </div>

@endsection

@push('scripts')
    <script>
        setTimeout(function () {
            window.location.href = @json(route('kiosk.index'));
        }, 10000);
    </script>
@endpush
