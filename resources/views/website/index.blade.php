<x-website-layout>

    <style>
        /* === Base Dark Theme === */
        body {
            background-color: #0d0d0d;
            color: #e5e5e5;
            font-family: 'Roboto', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
            font-weight: 600;
        }
        p, span {
            color: #cfcfcf;
        }

        /* === Primary Color (Bloc Infra Lime Green) === */
        .text-primary {
            color: #b3d33c !important;
        }
        .bg-primary {
            background-color: #b3d33c !important;
        }
        .btn-primary {
            background-color: #b3d33c !important;
            border: none;
            color: #000;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #c9ec4b !important;
            color: #000;
        }

        /* === Section Styling === */
        .bg-dark-section {
            background-color: #161616;
        }
        .service-item,
        .portfolio-box,
        .testimonial-item {
            background-color: #1c1c1c;
            border: 1px solid #2a2a2a;
            transition: 0.3s;
        }
        .service-item:hover,
        .portfolio-box:hover,
        .testimonial-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(179, 211, 60, 0.3);
        }

        /* === Carousel Captions & Layout === */
        #header-carousel {
            height: 85vh;
            min-height: 600px;
            position: relative;
        }

        #header-carousel .carousel-inner,
        #header-carousel .carousel-item {
            height: 100%;
        }

        #header-carousel .carousel-item img {
            height: 100%;
            object-fit: cover;
            filter: brightness(0.45) contrast(1.05);
        }

        .carousel-caption {
            background: transparent !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 0;
        }

        .hero-glass-card {
            background: rgba(10, 15, 30, 0.45);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 50px 60px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            max-width: 820px;
            margin: 0 auto;
            transform: translateY(20px);
            opacity: 0;
            animation: cardFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardFadeUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .hero-tagline {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #b3d33c;
            display: inline-block;
            margin-bottom: 22px;
            background: rgba(179, 211, 60, 0.1);
            padding: 6px 16px;
            border-radius: 50px;
            border: 1px solid rgba(179, 211, 60, 0.2);
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 800 !important;
            letter-spacing: -1px;
            line-height: 1.15;
            margin-bottom: 22px;
        }

        .hero-desc {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 35px;
            line-height: 1.65;
        }

        /* Scroll Down Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .scroll-indicator:hover {
            color: #b3d33c;
        }

        .scroll-mouse {
            width: 20px;
            height: 32px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            position: relative;
            margin-bottom: 8px;
            transition: border-color 0.3s ease;
        }

        .scroll-indicator:hover .scroll-mouse {
            border-color: #b3d33c;
        }

        .scroll-wheel {
            width: 4px;
            height: 6px;
            background-color: #b3d33c;
            border-radius: 2px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 6px;
            animation: wheelSlide 1.5s infinite;
        }

        @keyframes wheelSlide {
            0% { top: 6px; opacity: 1; }
            100% { top: 18px; opacity: 0; }
        }

        @media (max-width: 768px) {
            #header-carousel {
                height: 70vh;
                min-height: 500px;
            }
            .hero-glass-card {
                padding: 30px 24px;
                margin: 0 15px;
            }
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-desc {
                font-size: 1rem;
            }
            .scroll-indicator {
                display: none;
            }
        }

        /* === Professional Portfolio Style === */
        .portfolio-box img {
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .portfolio-box:hover img {
            transform: scale(1.08);
        }

        .portfolio-box:hover .portfolio-overlay {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        #portfolio-flters li {
            color: rgba(255,255,255,0.75);
            background: transparent;
            border: 1px solid rgba(255,255,255,0.12) !important;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        #portfolio-flters li:hover,
        #portfolio-flters li.active {
            background-color: #b3d33c !important;
            color: #000000 !important;
            border-color: #b3d33c !important;
            box-shadow: 0 4px 15px rgba(179, 211, 60, 0.3);
        }

        /* === Links === */
        a {
            color: #b3d33c;
            text-decoration: none;
        }
        a:hover {
            color: #d8fa60;
        }
    </style>

    <!-- Carousel -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('website/img/carousel-1.jpg') }}" alt="{{ __('Bloc Infra Project') }}">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="hero-glass-card">
                            <span class="hero-tagline">{{ __('Leaders in Infrastructure') }}</span>
                            <h1 class="hero-title">{{ __('Building Tomorrow, Today') }}</h1>
                            <p class="hero-desc">{{ __('Modern infrastructure, quality materials, and precision engineering delivered with integrity.') }}</p>
                            <a href="#about" class="btn btn-primary py-3 px-5 rounded-pill">{{ __('Discover More') }}</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('website/img/carousel-2.jpg') }}" alt="{{ __('Infrastructure Development') }}">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="hero-glass-card">
                            <span class="hero-tagline">{{ __('Engineered for Excellence') }}</span>
                            <h1 class="hero-title">{{ __('Quality That Endures') }}</h1>
                            <p class="hero-desc">{{ __('Delivering structural masterworks in every sector with pioneering techniques and innovation.') }}</p>
                            <a href="#services" class="btn btn-primary py-3 px-5 rounded-pill">{{ __('Our Services') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

            <!-- Scroll indicator -->
            <a href="#about" class="scroll-indicator">
                <div class="scroll-mouse">
                    <div class="scroll-wheel"></div>
                </div>
                <span>{{ __('Scroll') }}</span>
            </a>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="container-fluid py-6 px-5 bg-dark-section">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 text-uppercase mb-4"><span class="text-primary">{{ __('About') }}</span> {{ __('Bloc Infra') }}</h1>
                <p class="mb-4">
                    {{ __('Bloc Infra is a Kanpur-based construction and infrastructure company delivering modern, sustainable projects across commercial, residential, and public sectors. We combine advanced engineering with innovation and transparency to build long-lasting value.') }}
                </p>
                <div class="row gx-5 py-2">
                    <div class="col-sm-6">
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('Professional Engineers') }}</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('Comprehensive Planning') }}</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('Transparent Execution') }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('High-Quality Materials') }}</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('On-Time Delivery') }}</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ __('Sustainable Approach') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="img-fluid rounded shadow-lg" src="{{ asset('website/img/about.jpg') }}" alt="{{ __('Bloc Infra Team') }}">
            </div>
        </div>
    </div>

    <!-- Services -->
    <div id="services" class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:700px;">
            <h1 class="display-5 text-uppercase mb-4">{{ __('Our') }} <span class="text-primary">{{ __('Core Services') }}</span></h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-1.jpg') }}" alt="">
                    <h4 class="text-light mb-3">{{ __('Commercial Construction') }}</h4>
                    <p>{{ __('Corporate complexes and industrial structures with world-class quality and precision.') }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-2.jpg') }}" alt="">
                    <h4 class="text-light mb-3">{{ __('Residential Development') }}</h4>
                    <p>{{ __('Elegant, sustainable homes built to match modern lifestyles and environmental standards.') }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-3.jpg') }}" alt="">
                    <h4 class="text-light mb-3">{{ __('Infrastructure Projects') }}</h4>
                    <p>{{ __('Urban infrastructure solutions including roads, bridges, and smart utilities.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio -->
    <div id="projects" class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <h1 class="display-5 text-uppercase mb-4">{{ __('Our') }} <span class="text-primary">{{ __('Projects') }}</span></h1>
        </div>

        {{-- Filter categories --}}
        <div class="row g-0 justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <ul class="list-inline mb-0" id="portfolio-flters" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); padding: 8px 16px; border-radius: 50px; display: inline-block;">
                    <li class="btn btn-sm rounded-pill px-3 py-2 mx-1 fw-bold text-uppercase active" data-filter="*">
                        {{ __('All') }}
                    </li>
                    <li class="btn btn-sm rounded-pill px-3 py-2 mx-1 fw-bold text-uppercase" data-filter=".residential">
                        {{ __('Residential') }}
                    </li>
                    <li class="btn btn-sm rounded-pill px-3 py-2 mx-1 fw-bold text-uppercase" data-filter=".commercial">
                        {{ __('Commercial') }}
                    </li>
                    <li class="btn btn-sm rounded-pill px-3 py-2 mx-1 fw-bold text-uppercase" data-filter=".infrastructure">
                        {{ __('Infrastructure') }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="row g-4 portfolio-container">
            @php
                $projectsList = [
                    ['title' => __('Kanpur Smart Highway'), 'category' => 'infrastructure', 'cat_name' => __('Infrastructure'), 'img' => 'portfolio-1.jpg', 'desc' => __('High-speed smart expressway connecting key hubs.')],
                    ['title' => __('Emerald Heights Complex'), 'category' => 'residential', 'cat_name' => __('Residential'), 'img' => 'portfolio-2.jpg', 'desc' => __('Premium residential apartments with sustainable design.')],
                    ['title' => __('Grand Mall & Corporate Plaza'), 'category' => 'commercial', 'cat_name' => __('Commercial'), 'img' => 'portfolio-3.jpg', 'desc' => __('A state-of-the-art commercial and shopping center.')],
                    ['title' => __('Metro Station Expansion'), 'category' => 'infrastructure', 'cat_name' => __('Infrastructure'), 'img' => 'portfolio-4.jpg', 'desc' => __('Modern urban transit design and station development.')],
                    ['title' => __('Aroma Industrial Unit'), 'category' => 'commercial', 'cat_name' => __('Commercial'), 'img' => 'portfolio-5.jpg', 'desc' => __('Advanced manufacturing and industrial warehouse.')],
                    ['title' => __('Vasant Kunj Villas'), 'category' => 'residential', 'cat_name' => __('Residential'), 'img' => 'portfolio-6.jpg', 'desc' => __('Luxury eco-friendly villas matching modern living.')],
                ];
            @endphp

            @foreach ($projectsList as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 portfolio-item {{ $item['category'] }}">
                    <div class="portfolio-box position-relative overflow-hidden rounded shadow-lg" style="height: 280px; border: 1px solid rgba(255,255,255,0.05);">
                        <img class="img-fluid w-100 h-100" src="{{ asset('website/img/' . $item['img']) }}" alt="{{ $item['title'] }}" style="object-fit: cover;">
                        <div class="portfolio-overlay d-flex flex-column align-items-center justify-content-center px-4" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(rgba(179, 211, 60, 0.95), rgba(4, 15, 40, 0.95)); opacity: 0; transition: all 0.4s ease; transform: translateY(15px);">
                            <span class="text-uppercase fw-bold mb-1 text-dark" style="font-size: 11px; letter-spacing: 2px;">{{ $item['cat_name'] }}</span>
                            <h5 class="text-white fw-bold mb-2 text-center">{{ $item['title'] }}</h5>
                            <p class="text-white-50 small mb-3 text-center px-2" style="font-size: 12px; line-height: 1.4;">{{ $item['desc'] }}</p>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" href="{{ asset('website/img/' . $item['img']) }}" data-lightbox="portfolio" style="width: 40px; height: 40px;">
                                    <i class="bi bi-zoom-in text-dark fs-6"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" href="{{ route('website.contact') }}" style="width: 40px; height: 40px;">
                                    <i class="bi bi-link-45deg fs-6"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Blog -->
    <div class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <h1 class="display-5 text-uppercase mb-4">{{ __('Latest') }} <span class="text-primary">{{ __('Insights') }}</span></h1>
        </div>
        <div class="row g-5">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="p-4 rounded shadow-sm">
                        <img class="img-fluid rounded mb-3" src="{{ asset('website/img/blog-' . $i . '.jpg') }}">
                        <h5 class="text-light mb-2">{{ __('Project Spotlight') }} {{ $i }}</h5>
                        <p class="small text-muted"><i class="far fa-calendar-alt text-primary me-2"></i>01 Nov 2025</p>
                        <p>{{ __('Explore how Bloc Infra is shaping sustainable infrastructure for the next generation.') }}</p>
                        <a href="#" class="fw-bold">{{ __('Read More') }} <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            @endfor
        </div>
    </div>

</x-website-layout>
