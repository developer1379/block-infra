<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- Head Section --}}
@include('website.partials.head')

<body>


    @include('website.partials.header')
    {{-- If you use Blade components for header, you can replace the above line with: --}}
    {{-- <x-header /> --}}

    {{-- Main Content --}}
    {{ $slot }}
    @include('website.partials.toast')

    {{-- Footer --}}
    @include('website.partials.footer')
    {{-- Or use component --}}
    {{-- <x-footer /> --}}

    {{-- JavaScript Includes --}}
    @include('website.partials.js')

</body>

</html>

