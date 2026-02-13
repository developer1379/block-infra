<style>
    /* Dropdown Menu Fix for Dark Navbar */
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

    .navbar .dropdown-menu .dropdown-item:hover,
    .navbar .dropdown-menu .dropdown-item:focus {
        background-color: #b3d33c !important;
        color: #000 !important;
    }

    /* Google Translate Integration */
    #google_translate_element {
        display: inline-block;
        vertical-align: middle;
    }

    .goog-te-gadget-simple {
        background-color: #ffffff !important;
        border: 1px solid #b3d33c !important;
        padding: 4px 8px !important;
        border-radius: 2px !important;
        cursor: pointer;
    }

    .goog-te-gadget img,
    .goog-te-gadget span,
    .goog-te-menu-value span:nth-child(3) {
        display: none !important;
    }

    .goog-te-menu-value span {
        color: #333 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
    }

    body {
        top: 0 !important;
    }

    .goog-te-banner-frame.skiptranslate {
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
