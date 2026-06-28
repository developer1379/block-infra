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

    /* ================= CUSTOM LANG SWITCHER DROPDOWN ================= */
    .lang-switcher .dropdown-toggle {
        font-size: 13px !important;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: 1px solid rgba(0, 0, 0, 0.12);
        padding: 6px 14px;
        border-radius: 30px;
        background-color: #ffffff;
        color: #333333;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .lang-switcher .dropdown-toggle:hover {
        border-color: #b3d33c;
        background-color: #f8f9fa;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .lang-switcher .dropdown-menu {
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        border-radius: 12px !important;
        margin-top: 8px !important;
        padding: 6px 0 !important;
        background-color: #ffffff !important;
        min-width: 140px;
        z-index: 9999 !important;
    }

    .lang-switcher .dropdown-item {
        font-size: 13px !important;
        font-weight: 500;
        color: #495057 !important;
        padding: 8px 16px !important;
        transition: all 0.2s ease;
    }

    .lang-switcher .dropdown-item:hover {
        background-color: #b3d33c !important;
        color: #000000 !important;
    }

    .lang-switcher .dropdown-item.active {
        background-color: #f1f3f5 !important;
        color: #b3d33c !important;
        font-weight: 700;
    }
</style>


<!-- TOP BAR -->
<div class="container-fluid bg-light py-1 px-4 d-none d-lg-block border-bottom" style="position: relative; z-index: 1030;">
    <div class="row align-items-center text-center gx-0">

        <div class="col-lg-3 py-1">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-geo-alt-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">{{ __('Our Office') }}</small><br>
                    <small class="text-muted">{{ __('Vikas Nagar, Kanpur') }}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-envelope-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">{{ __('Email Us') }}</small><br>
                    <small><a href="mailto:info@blocinfra.com" class="text-muted">info@blocinfra.com</a></small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start border-end">
            <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-telephone-fill me-2" style="color:#b3d33c;"></i>
                <div class="text-start">
                    <small class="fw-semibold text-dark">{{ __('Call Us') }}</small><br>
                    <small class="text-muted">+91 73111 22392</small>
                </div>
            </div>
        </div>

        <!-- TRANSLATE DROPDOWN -->
        <div class="col-lg-3 py-1 text-end lang-switcher">
            <div class="dropdown d-inline-block">
                <button class="btn dropdown-toggle" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-translate me-2" style="color:#b3d33c;"></i>
                    {{ app()->getLocale() == 'hi' ? 'हिन्दी (HI)' : 'English (EN)' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                            English (EN)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'hi' ? 'active' : '' }}" href="{{ route('lang.switch', 'hi') }}">
                            हिन्दी (HI)
                        </a>
                    </li>
                </ul>
            </div>
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

        <!-- Mobile PWA Download Button -->
        <button class="pwa-install-nav-btn btn text-white d-lg-none ms-auto me-2 align-items-center justify-content-center"
            style="display: none; background:#0f766e; border-radius: 4px; width: 38px; height: 38px; padding: 0; border: none;">
            <i class="bi bi-cloud-arrow-down-fill fs-5"></i>
        </button>
 
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 align-items-center">

                <a href="{{ route('website.home') }}" class="nav-item nav-link {{ Request::routeIs('website.home') ? 'active' : '' }} text-uppercase">{{ __('Home') }}</a>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown">{{ __('Solutions') }}</a>
                    <div class="dropdown-menu m-0 bg-dark border-0 rounded-0">
                        <a href="{{ route('website.construction') }}"
                            class="dropdown-item text-white-50">{{ __('Construction') }}</a>
                        <a href="{{ route('website.infrastructure') }}"
                            class="dropdown-item text-white-50">{{ __('Infrastructure') }}</a>
                        <a href="{{ route('website.project-management') }}" class="dropdown-item text-white-50">{{ __('Project Management') }}</a>
                        <a href="{{ route('website.design-consulting') }}" class="dropdown-item text-white-50">{{ __('Design & Consulting') }}</a>
                    </div>
                </div>

                <a href="{{ route('website.about') }}" class="nav-item nav-link {{ Request::routeIs('website.about') ? 'active' : '' }} text-uppercase">{{ __('About Us') }}</a>
                <a href="{{ route('website.faqs') }}" class="nav-item nav-link {{ Request::routeIs('website.faqs') ? 'active' : '' }} text-uppercase">{{ __('FAQs') }}</a>
                <a href="{{ route('website.calculator') }}" class="nav-item nav-link {{ Request::routeIs('website.calculator') ? 'active' : '' }} text-uppercase">{{ __('Calculator') }}</a>
                <a href="{{ route('website.contact') }}" class="nav-item nav-link {{ Request::routeIs('website.contact') ? 'active' : '' }} text-uppercase">{{ __('Contact Us') }}</a>

                <!-- Mobile Language Switcher (Visible only on mobile/tablet) -->
                <div class="nav-item dropdown d-lg-none my-2 w-100 px-3">
                    <a class="nav-link dropdown-toggle text-uppercase text-white-50 py-2 border rounded border-secondary text-center" data-bs-toggle="dropdown">
                        <i class="bi bi-translate me-2" style="color:#b3d33c;"></i>
                        {{ app()->getLocale() == 'hi' ? 'हिन्दी (HI)' : 'English (EN)' }}
                    </a>
                    <div class="dropdown-menu m-0 bg-dark border-0 rounded-0 text-center w-100">
                        <a href="{{ route('lang.switch', 'en') }}" class="dropdown-item text-white-50 py-2 {{ app()->getLocale() == 'en' ? 'active text-white' : '' }}">English (EN)</a>
                        <a href="{{ route('lang.switch', 'hi') }}" class="dropdown-item text-white-50 py-2 {{ app()->getLocale() == 'hi' ? 'active text-white' : '' }}">हिन्दी (HI)</a>
                    </div>
                </div>

                <!-- PWA Install Button -->
                <button class="pwa-install-nav-btn nav-item nav-link btn text-white px-4 ms-lg-3 my-2 my-lg-0 text-uppercase align-self-start align-items-center"
                    style="display: none; background:#0f766e; font-weight:600; border-radius: 4px; border: none; outline: none; gap: 8px;">
                    <i class="bi bi-cloud-arrow-down-fill"></i> {{ __('Download') }}
                </button>

                <a href="{{ route('website.login') }}"
                    class="nav-item nav-link text-dark px-4 ms-lg-3 my-2 my-lg-0 text-uppercase d-inline-flex align-self-start align-items-center"
                    style="background:#b3d33c; font-weight:600; border-radius: 4px;">
                    {{ __('Login') }} <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>
        </div>
    </nav>
</div>
