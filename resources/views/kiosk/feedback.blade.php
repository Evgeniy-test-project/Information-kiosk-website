@extends('kiosk.layout')

@section('title', 'Обратная связь')

@php
    $pageTitle = 'Обратная связь';
    $showBack = true;
    $backUrl = route('kiosk.index');
@endphp


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/simple-keyboard.css') }}">

@endpush

@section('content')
      <form method="POST" action="{{ route('kiosk.feedback.submit') }}" class="w-3/4 mx-auto space-y-6 p-4 bg-white rounded-xl shadow-sm">
          @csrf

          <!-- Поле Сообщение -->
          <div class="space-y-1">
              <label for="message" class="block text-sm font-medium text-gray-700">
                  Текст обращения
                  <span class="text-red-500 font-bold">*</span>
              </label>

              <textarea
                  id="message"
                  name="message"
                  rows="4"
                  required
                  class="kiosk-input w-full px-3 py-2 h-40 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none"
                  autocomplete="off"
              >{{ old('message') }}</textarea>

              @error('message')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
          </div>

          <!-- Кнопка отправки -->
          <button
              type="submit"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
          >
              Отправить
          </button>
      </form>

      <div>
          <div class="simple-keyboard" id="virtual-keyboard"></div>
      </div>



@endsection

@push('scripts')
    <script src="{{ asset('js/simple-keyboard.min.js') }}"></script>
    <script src="{{ asset('js/kiosk-keyboard.js') }}"></script>


@endpush

