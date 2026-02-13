<style>
    /* 1. Navbar & Dropdown Styling */
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

    /* 2. Professional Google Translate Fixes */
    /* FORCE HIDE the top bar and the "Translated to" banner */
    body {
        top: 0 !important;
        position: static !important;
    }

    .goog-te-banner-frame.skiptranslate,
    .goog-te-banner-frame {
        display: none !important;
        visibility: hidden !important;
    }

    .goog-tooltip,
    .goog-tooltip:hover {
        display: none !important;
    }

    .goog-text-highlight {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    #google_translate_element {
        min-width: 150px;
        display: inline-block;
        vertical-align: middle;
    }

    /* Style the main button box */
    .goog-te-gadget-simple {
        background-color: #ffffff !important;
        border: 1px solid #b3d33c !important;
        padding: 5px 10px !important;
        border-radius: 4px !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center;
        text-decoration: none !important;
    }

    /* Hide the Google Branding but keep text */
    .goog-te-gadget-icon {
        display: none !important;
    }

    .goog-te-gadget>span {
        display: none !important;
    }

    .goog-te-menu-value {
        margin: 0 !important;
        display: flex !important;
        align-items: center;
    }

    .goog-te-menu-value span {
        color: #333 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 11px !important;
        display: inline-block !important;
    }

    /* Hide arrows */
    .goog-te-menu-value span:nth-child(3),
    .goog-te-menu-value span:nth-child(5) {
        display: none !important;
    }

    /* Hide Google top translate bar completely */
    body {
        top: 0px !important;
        position: static !important;
    }

    /* Hide banner iframe */
    .goog-te-banner-frame,
    iframe.goog-te-banner-frame {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
    }

    /* Remove extra spacing Google adds */
    .skiptranslate {
        display: none !important;
    }

    .goog-te-gadget-icon {
        display: none !important;
    }
</style>

<div class="container-fluid bg-light py-1 px-4 d-none d-lg-block border-bottom">
    <div class="row align-items-center text-center gx-0">
        <div class="col-lg-3 py-1">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-geo-alt-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Our Office</small>
                    <small class="text-muted">Vikas Nagar, Kanpur</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 py-1 border-start">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-envelope-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Email Us</small>
                    <small><a href="mailto:info@blocinfra.com"
                            class="text-muted text-decoration-none">info@blocinfra.com</a></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 py-1 border-start border-end">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-telephone-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Call Us</small>
                    <small class="text-muted">+91 73111 22392</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 py-1">
            <div id="google_translate_element"></div>
        </div>
    </div>
</div>
<div class="container-fluid sticky-top bg-dark shadow-sm px-4 pe-lg-0">
    <nav class="navbar navbar-expand-lg navbar-dark py-2 py-lg-0">
        <a href="{{ route('website.home') }}" class="navbar-brand notranslate">
            <h1 class="m-0 fs-2 text-uppercase text-white">
                <i class="bi bi-building me-2" style="color:#b3d33c;"></i>BLOC INFRA
            </h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('website.home') }}" class="nav-item nav-link active text-uppercase">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-uppercase"
                        data-bs-toggle="dropdown">Solutions</a>
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
                    class="nav-item nav-link text-dark px-4 ms-3 d-none d-lg-block text-uppercase"
                    style="background-color:#b3d33c; border-radius:0; font-weight:600;">
                    Login <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </nav>
</div>

{{-- Script with "Auto-Remove Bar" Logic --}}
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }

    // Forcefully remove the Google top bar if it appears
    setInterval(function() {
        var frame = document.querySelector('.goog-te-banner-frame');
        if (frame) {
            frame.style.display = 'none';
            document.body.style.top = '0px';
        }
    }, 500);
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>

{{-- <script>
function removeGoogleBar() {
    const frame = document.querySelector('.goog-te-banner-frame');
    if (frame) {
        frame.remove();
    }
    document.body.style.top = '0px';
}

setInterval(removeGoogleBar, 500);
</script> --}}
