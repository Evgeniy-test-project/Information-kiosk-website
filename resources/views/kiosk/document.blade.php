@extends('kiosk.layout')

@section('title', $document->title)

@php
    $pageTitle = $document->title;
    $showBack = true;
@endphp

@section('content')
    <div class="flex flex-col items-center gap-4 p-4 sm:p-6">
        <!-- Блок с изображением -->
        <div class="w-full max-w-2xl">
            <img
                src="{{ $imageUrl }}"
                alt="Страница {{ $page }}"
                class="w-full h-auto block"
            >

        </div>

        <!-- Панель управления -->
        <div class="flex flex-wrap items-center justify-center gap-3 w-full sm:w-auto">
            {{-- Кнопка «Назад» --}}
            @if($page > 1)
                <a
                    href="{{ route('kiosk.document.page', ['document' => $document, 'page' => $page - 1]) }}"
                    class="inline-flex items-center px-4 py-2 border border-blue-500 text-blue-600 bg-white hover:bg-blue-50 hover:text-blue-700 rounded-md text-sm font-medium transition-colors duration-200"
                >
                    ← Назад
                </a>
            @else
                <span
                    class=" inline-flex items-center px-4 py-2 text-gray-400 bg-gray-100 border border-transparent rounded-md text-sm font-medium cursor-not-allowed">
                ← Назад
            </span>
            @endif

            {{-- Счетчик страниц --}}
            <span class="kiosk-document__counter text-sm text-gray-700 font-medium px-2 sm:px-4">
            {{ $page }} из {{ $document->page_count }}
        </span>

            {{-- Кнопка «Вперёд» --}}
            @if($page < $document->page_count)
                <a
                    href="{{ route('kiosk.document.page', ['document' => $document, 'page' => $page + 1]) }}"
                    class="kiosk-btn kiosk-btn--nav inline-flex items-center px-4 py-2 border border-blue-500 text-blue-600 bg-white hover:bg-blue-50 hover:text-blue-700 rounded-md text-sm font-medium transition-colors duration-200"
                >
                    Вперёд →
                </a>
            @else
                <span
                    class="kiosk-btn kiosk-btn--nav kiosk-btn--disabled inline-flex items-center px-4 py-2 text-gray-400 bg-gray-100 border border-transparent rounded-md text-sm font-medium cursor-not-allowed">
                Вперёд →
            </span>
            @endif
        </div>
    </div>

@endsection
