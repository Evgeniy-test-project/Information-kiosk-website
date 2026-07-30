{{--<p class="text-center"><br>
    © ГАУЗ СО Детская городская поликлиника № 13, г. Екатеринбург.
</p>--}}
@php
    $setting = \App\Models\KioskSetting::where('key', 'Футер')->first();
    $setValue = $setting ? $setting->value : '';
@endphp
<br>
<p class="text-center">{{$setValue}}</p>

