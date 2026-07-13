@extends('kiosk.pdf-layout')

@section('title', $document->title)

@php
    $pageTitle = $document->title;
    $showBack = true;
@endphp

@section('content')

    <!-- Здесь будет содержимое PDF файла -->
    <embed width="100%" height="100%" name="plugin" src="{{$file}}" type="application/pdf">

@endsection
