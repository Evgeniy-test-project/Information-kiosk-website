<html>
<head>
    <title></title>
        <link rel="stylesheet" href="https://unpkg.com/simple-keyboard@latest/build/css/index.css">
{{--    @vite(['resources/css/app.css','resources/css/index.css'])--}}
</head>

<body>
{{--<input class="input" placeholder="Tap on the virtual keyboard to start" />--}}

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
        class="input kiosk-input w-full px-3 py-2 h-40 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none"
        autocomplete="off"
    >{{ old('message') }}</textarea>

    @error('message')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="simple-keyboard"></div>

<script src="https://unpkg.com/simple-keyboard@latest/build/index.js"></script>
{{--@vite(['resources/js/index.js'])--}}

</body>
</html>
