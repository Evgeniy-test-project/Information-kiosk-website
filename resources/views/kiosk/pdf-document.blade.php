@extends('kiosk.layout')

@php
//    $showBack = true;
@endphp

@section('content')

    <!-- Здесь будет содержимое PDF файла -->
    <iframe
        src="{{ $file }}"
        width="100%"
        height="100%"
        style="border: none;"
        title="PDF Document"
    >
        Ваш браузер не поддерживает отображение PDF. <a href="{{ $file }}">Скачать файл</a>.
    </iframe>

@endsection
