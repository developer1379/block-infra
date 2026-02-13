<!DOCTYPE html>
<html lang="en">
{{-- Head Section --}}
@include('website.common.head')

<style>
    /* 1. Hide the Google Translate Top Banner */
    .goog-te-banner-frame.skiptranslate {
        display: none !important;
    }

    /* 2. Prevent the body from being pushed down */
    body {
        top: 0px !important;
    }

    /* 3. Hide the 'Original Text' tooltip that appears on hover (optional but recommended) */
    .goog-te-balloon-frame {
        display: none !important;
    }

    #goog-gt-tt {
        display: none !important;
    }

    .goog-text-highlight {
        background: none !important;
        box-shadow: none !important;
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

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

</body>

</html>
