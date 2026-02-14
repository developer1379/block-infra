<style>
    /* ================= NAVBAR DROPDOWN ================= */
    .navbar .dropdown-menu {
        background-color: #0f1114 !important;
        border: none;
        padding: 0;
        min-width: 200px;
    }

    .navbar .dropdown-menu .dropdown-item {
        color: #ddd !important;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .navbar .dropdown-menu .dropdown-item:hover {
        background-color: #b3d33c !important;
        color: #000 !important;
    }

    /* ================= GOOGLE TRANSLATE FIX ================= */

    /* remove highlight */
    .goog-text-highlight {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* style dropdown */
    .goog-te-gadget-simple {
        background: #fff !important;
        border: 1px solid #b3d33c !important;
        padding: 6px 10px !important;
        border-radius: 4px !important;
        font-size: 12px !important;
    }

    .goog-te-gadget-icon {
        display: none !important;
    }

    /* ================= MARGIN WHEN GOOGLE BAR APPEARS ================= */

    /* smooth animation */
    .translate-wrapper {
        transition: margin-top 0.25s ease;
    }

    /* push down when translated */
    .translate-wrapper.translated {
        margin-top: 42px;
        /* height of google bar */
    }
</style>


<!-- TOP BAR -->
<div class="container-fluid bg-light py-1 px-4 d-none d-lg-block border-bottom">
    <div class="row align-items-center text-center gx-0">

        <div class="col-lg-3 py-1">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-geo-alt-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">Our Office</small><br>
                    <small class="text-muted">Vikas Nagar, Kanpur</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-envelope-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">Email Us</small><br>
                    <small><a href="mailto:info@blocinfra.com" class="text-muted">info@blocinfra.com</a></small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start border-end">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-telephone-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">Call Us</small><br>
                    <small class="text-muted">+91 73111 22392</small>
                </div>
            </div>
        </div>

        <!-- TRANSLATE DROPDOWN -->
        <div class="col-lg-3 py-1 text-end">
            <div id="google_translate_element"></div>
        </div>

    </div>
</div>


<!-- NAVBAR -->
<div class="container-fluid sticky-top bg-dark shadow-sm px-4 pe-lg-0">
    <nav class="navbar navbar-expand-lg navbar-dark py-2 py-lg-0">

        <a href="{{ route('website.home') }}" class="navbar-brand notranslate">
            <h1 class="m-0 fs-2 text-uppercase text-white">
                <i class="bi bi-building me-2" style="color:#b3d33c;"></i>BLOC INFRA
            </h1>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">

                <a href="{{ route('website.home') }}" class="nav-item nav-link active text-uppercase">Home</a>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown">Solutions</a>
                    <div class="dropdown-menu m-0 bg-dark border-0 rounded-0">
                        <a href="{{ route('website.construction') }}"
                            class="dropdown-item text-white-50">Construction</a>
                        <a href="{{ route('website.infrastructure') }}"
                            class="dropdown-item text-white-50">Infrastructure</a>
                        <a href="{{ route('website.project-management') }}" class="dropdown-item text-white-50">Project
                            Management</a>
                        <a href="{{ route('website.design-consulting') }}" class="dropdown-item text-white-50">Design &
                            Consulting</a>
                    </div>
                </div>

                <a href="{{ route('website.about') }}" class="nav-item nav-link text-uppercase">About Us</a>
                <a href="{{ route('website.faqs') }}" class="nav-item nav-link text-uppercase">FAQs</a>
                <a href="{{ route('website.calculator') }}" class="nav-item nav-link text-uppercase">Calculator</a>
                <a href="{{ route('website.contact') }}" class="nav-item nav-link text-uppercase">Contact Us</a>

                <a href="{{ route('website.login') }}"
                    class="nav-item nav-link text-dark px-4 ms-lg-3 my-2 my-lg-0 text-uppercase d-inline-flex align-self-start align-items-center"
                    style="background:#b3d33c; font-weight:600; border-radius: 4px;">
                    Login <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>
        </div>
    </nav>
</div>

<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi',
            autoDisplay: false
        }, 'google_translate_element');
    }

    /* detect google bar and push layout */
    setInterval(function() {

        const banner = document.querySelector('.goog-te-banner-frame');
        const wrapper = document.querySelector('.translate-wrapper');

        if (!wrapper) return;

        if (banner) {
            wrapper.classList.add("translated");
        } else {
            wrapper.classList.remove("translated");
        }

    }, 500);
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
