<!DOCTYPE html>
<html lang="en">
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

  <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: true, // This helps prevent the intrusive pop-ups
            multilanguagePage: true
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>

