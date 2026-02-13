{{-- Professional Google Translate Styling --}}
<style>
    /* Prevents the unprofessional top bar and layout jumping */
    body { top: 0 !important; position: static !important; }
    .goog-te-banner-frame.skiptranslate, .goog-te-banner-frame { display: none !important; visibility: hidden !important; }
    .goog-tooltip, .goog-tooltip:hover { display: none !important; }
    .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; }

    /* Style the widget to match your clean UI */
    #google_translate_element {
        display: inline-block;
        padding-top: 4px;
    }

    .goog-te-gadget-simple {
        background-color: #f1f5f9 !important; /* Matches your bg-slate-100 search bar */
        border: 1px solid #e2e8f0 !important;
        padding: 6px 10px !important;
        border-radius: 9999px !important; /* Full rounded to match search bar */
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center;
        text-decoration: none !important;
    }

    /* Hide Google branding but keep English/Hindi text visible */
    .goog-te-gadget-icon { display: none !important; }
    .goog-te-gadget > span { display: none !important; }

    .goog-te-menu-value {
        margin: 0 !important;
        display: flex !important;
        align-items: center;
    }

    .goog-te-menu-value span {
        color: #334155 !important; /* text-slate-700 */
        font-weight: 500 !important;
        text-transform: uppercase;
        font-size: 11px !important;
        display: inline-block !important;
    }

    /* Hide arrows and Google branding separators */
    .goog-te-menu-value span:nth-child(3),
    .goog-te-menu-value span:nth-child(5) {
        display: none !important;
    }
</style>

<header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm px-6 py-3">
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden text-slate-500 hover:text-primary focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <div class="hidden md:flex items-center gap-4 relative group">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-hover:text-primary transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text"
                        class="pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none"
                        placeholder="Search...">
                </div>

                <div id="google_translate_element" class="hidden xl:block"></div>
            </div>
        </div>

        <div class="flex items-center gap-4">

            {{-- Notifications --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false"
                    class="relative w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-500 transition-colors">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white animate-pulse"></span>
                </button>

                <div x-show="open" x-transition.origin.top.right x-cloak
                    class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-slate-700">Notifications</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-gray-50">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user-plus text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-700"><strong>Martin</strong> added a customer.</p>
                                <p class="text-xs text-slate-400 mt-1">3:20 am</p>
                            </div>
                        </a>
                    </div>
                    <a href="#" class="block text-center py-2 text-xs font-semibold text-primary hover:bg-slate-50">View All</a>
                </div>
            </div>

            {{-- User Profile --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false"
                    class="flex items-center gap-2 hover:bg-slate-50 rounded-full pl-2 pr-4 py-1 border border-transparent hover:border-gray-200 transition-all">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=0f766e&color=fff"
                        class="w-8 h-8 rounded-full object-cover">
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-slate-700 leading-none">
                            {{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-500 leading-none mt-1">Administrator</p>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
                </button>

                <div x-show="open" x-transition.origin.top.right x-cloak
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-1">
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        <i class="fa-regular fa-user w-4"></i> Profile
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

{{-- Google Translate Initialization Script --}}
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }

    // Forcefully remove the Google top bar if it appears every 500ms
    setInterval(function() {
        var frame = document.querySelector('.goog-te-banner-frame');
        if (frame) {
            frame.style.display = 'none';
            document.body.style.top = '0px';
        }
    }, 500);
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
