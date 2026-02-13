{{-- ===== GOOGLE TRANSLATE MODERN UI ===== --}}
<style>
    /* hide google top bar */
    body {
        top: 0 !important;
        position: static !important;
    }

    .goog-te-banner-frame.skiptranslate,
    .goog-te-banner-frame {
        display: none !important;
    }

    .goog-text-highlight {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* ===== MODERN LANGUAGE SWITCHER ===== */
    .lang-switcher {
        display: inline-flex;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 3px;
        gap: 2px;
    }

    .lang-btn {
        border: none;
        background: transparent;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        border-radius: 9999px;
        cursor: pointer;
        transition: .2s;
    }

    .lang-btn.active {
        background: #0f766e;
        color: #fff;
    }
</style>


<header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm px-6 py-3">
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-primary">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <div class="hidden md:flex items-center gap-4">

                {{-- SEARCH --}}
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text"
                        class="pl-10 pr-4 py-2 bg-slate-100 rounded-full text-sm w-64 focus:ring-2 focus:ring-primary outline-none"
                        placeholder="Search...">
                </div>

                {{-- LANGUAGE SWITCHER --}}
                <div class="hidden xl:block">
                    <div class="lang-switcher">
                        <button onclick="setLang('en')" id="btn-en" class="lang-btn active">EN</button>
                        <button onclick="setLang('hi')" id="btn-hi" class="lang-btn">HI</button>
                    </div>
                </div>

                {{-- hidden google widget --}}
                <div id="google_translate_element" style="display:none;"></div>

            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="flex items-center gap-4">

            {{-- notifications + profile keep same --}}
            <!-- YOUR EXISTING NOTIFICATION & PROFILE CODE HERE -->

        </div>
    </div>
</header>


{{-- ===== GOOGLE SCRIPT ===== --}}
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi',
            autoDisplay: false
        }, 'google_translate_element');
    }

    /* change language */
    function setLang(lang) {
        const select = document.querySelector(".goog-te-combo");
        if (select) {
            select.value = lang;
            select.dispatchEvent(new Event("change"));
        }

        document.getElementById("btn-en").classList.remove("active");
        document.getElementById("btn-hi").classList.remove("active");
        document.getElementById("btn-" + lang).classList.add("active");
    }

    /* remove google top bar */
    setInterval(() => {
        const frame = document.querySelector('.goog-te-banner-frame');
        if (frame) frame.remove();
        document.body.style.top = '0px';
    }, 500);
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
