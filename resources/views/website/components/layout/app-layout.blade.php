<!DOCTYPE html>
<html lang="en">
{{-- Head Section --}}
@include('website.common.head')

<body>
    {{-- Header --}}
    @include('website.common.header')
    {{-- If you use Blade components for header, you can replace the above line with: --}}
    {{-- <x-header /> --}}


    {{-- Main Content --}}
    {{ $slot }}

    {{-- Footer --}}
    @include('website.common.footer')
    {{-- Or use component --}}
    {{-- <x-footer /> --}}

    {{-- JavaScript Includes --}}
    @include('website.common.js')
</body>

</html>
