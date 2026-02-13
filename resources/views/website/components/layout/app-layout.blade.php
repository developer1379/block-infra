<!DOCTYPE html>
<html lang="en">
{{-- Head Section --}}
@include('website.common.head')

<style>
    /* Keeps the header from jumping down when the translator loads */
    body {
        top: 0 !important;
    }

    .goog-te-banner-frame.skiptranslate {
        display: none !important;
    }

    .goog-te-gadget {
        font-family: inherit !important;
    }

    /* Optional: Hides the "Powered by Google" text for a cleaner look */
    .goog-te-gadget span {
        display: none !important;
    }
</style>

<body>


    @include('website.common.header')
    {{-- If you use Blade components for header, you can replace the above line with: --}}
    {{-- <x-header /> --}}

    {{-- Main Content --}}
    {{ $slot }}
    @include('website.common.toast')

    {{-- Footer --}}
    @include('website.common.footer')
    {{-- Or use component --}}
    {{-- <x-footer /> --}}

    {{-- JavaScript Includes --}}
    @include('website.common.js')

    {{-- Google Translate Logic --}}
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
</body>

</html>
