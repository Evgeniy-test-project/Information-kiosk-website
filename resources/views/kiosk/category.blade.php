@extends('kiosk.layout')

@section('title', $title)

@php
    $pageTitle = $title;
    $showBack = $backUrl !== null;
@endphp

@section('content')
    <div class="p-5">
        @if($children->isNotEmpty())
            <!-- Контейнер для кнопок -->
            <div class=" ">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach($children as $child)
                            <a href="{{ route('kiosk.category', $child) }}"
                               class="bg-blue-500 text-white px-4 py-6 rounded-lg hover:bg-blue-600 text-[25px]"
                               :class="index % 2 === 0 ? 'col-start-1' : 'col-start-2'">
                                {{ $child->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        @endif

        @if($documents->isNotEmpty())
            <div class="kiosk-buttons grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($documents as $document)
                    <a href="{{ route('kiosk.document', $document) }}"
                       class="bg-blue-500 text-white px-4 py-6 rounded-lg hover:bg-blue-600 text-[25px]"
                       :class="index % 2 === 0 ? 'col-start-1' : 'col-start-2'">
                        {{ $document->title }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($children->isEmpty() && $documents->isEmpty())
            <p class="pt-15">В этом разделе пока нет материалов.</p>
        @endif
    </div>

    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Добро пожаловать в нашу клинику!</h2>
        <p class="text-gray-600">Здесь вы можете получить всю необходимую информацию о работе медицинского
            учреждения.</p>
        <a href="{{ route('kiosk.feedback') }}" class="kiosk-btn kiosk-btn--secondary">Обратная связь</a>
    </div>
@endsection
