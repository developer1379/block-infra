<x-layout.app-layout>

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

        /* === Carousel Captions === */
        .carousel-caption h1,
        .carousel-caption p {
            text-shadow: 0 0 10px rgba(0,0,0,0.7);
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
                    <img class="w-100" src="{{ asset('website/img/carousel-1.jpg') }}" alt="Bloc Infra Project">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="p-3" style="max-width:900px;">
                            <i class="fa fa-city fa-4x text-primary mb-4 d-none d-sm-block"></i>
                            <h1 class="display-3 fw-bold text-white mb-md-3">Building Tomorrow, Today</h1>
                            <p class="lead mb-4 text-light">Modern infrastructure, quality materials, and precision engineering.</p>
                            <a href="#about" class="btn btn-primary py-md-3 px-md-5">Discover More</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('website/img/carousel-2.jpg') }}" alt="Infrastructure Development">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="p-3" style="max-width:900px;">
                            <i class="fa fa-hard-hat fa-4x text-primary mb-4 d-none d-sm-block"></i>
                            <h1 class="display-3 fw-bold text-white mb-md-3">Quality That Endures</h1>
                            <p class="lead mb-4 text-light">Delivering excellence in every project with innovation and integrity.</p>
                            <a href="#services" class="btn btn-primary py-md-3 px-md-5">Our Services</a>
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
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="container-fluid py-6 px-5 bg-dark-section">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 text-uppercase mb-4"><span class="text-primary">About</span> Bloc Infra</h1>
                <p class="mb-4">
                    Bloc Infra is a Kanpur-based construction and infrastructure company delivering modern,
                    sustainable projects across commercial, residential, and public sectors.
                    We combine advanced engineering with innovation and transparency to build long-lasting value.
                </p>
                <div class="row gx-5 py-2">
                    <div class="col-sm-6">
                        <p><i class="fa fa-check text-primary me-3"></i>Professional Engineers</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Comprehensive Planning</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Transparent Execution</p>
                    </div>
                    <div class="col-sm-6">
                        <p><i class="fa fa-check text-primary me-3"></i>High-Quality Materials</p>
                        <p><i class="fa fa-check text-primary me-3"></i>On-Time Delivery</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Sustainable Approach</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="img-fluid rounded shadow-lg" src="{{ asset('website/img/about.jpg') }}" alt="Bloc Infra Team">
            </div>
        </div>
    </div>

    <!-- Services -->
    <div id="services" class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:700px;">
            <h1 class="display-5 text-uppercase mb-4">Our <span class="text-primary">Core Services</span></h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-1.jpg') }}" alt="">
                    <h4 class="text-light mb-3">Commercial Construction</h4>
                    <p>Corporate complexes and industrial structures with world-class quality and precision.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-2.jpg') }}" alt="">
                    <h4 class="text-light mb-3">Residential Development</h4>
                    <p>Elegant, sustainable homes built to match modern lifestyles and environmental standards.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center p-4 rounded shadow-sm">
                    <img class="img-fluid mb-3 rounded" src="{{ asset('website/img/service-3.jpg') }}" alt="">
                    <h4 class="text-light mb-3">Infrastructure Projects</h4>
                    <p>Urban infrastructure solutions including roads, bridges, and smart utilities.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio -->
    <div class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <h1 class="display-5 text-uppercase mb-4">Our <span class="text-primary">Projects</span></h1>
        </div>
        <div class="row g-4 portfolio-container">
            @for ($i = 1; $i <= 6; $i++)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="portfolio-box position-relative overflow-hidden rounded shadow-sm">
                        <img class="img-fluid w-100" src="{{ asset('website/img/portfolio-' . $i . '.jpg') }}">
                        <a class="portfolio-btn" href="{{ asset('website/img/portfolio-' . $i . '.jpg') }}" data-lightbox="portfolio">
                            <i class="bi bi-plus text-primary fs-3"></i>
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    </div>


    <!-- Blog -->
    <div class="container-fluid bg-dark-section py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width:600px;">
            <h1 class="display-5 text-uppercase mb-4">Latest <span class="text-primary">Insights</span></h1>
        </div>
        <div class="row g-5">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="p-4 rounded shadow-sm">
                        <img class="img-fluid rounded mb-3" src="{{ asset('website/img/blog-' . $i . '.jpg') }}">
                        <h5 class="text-light mb-2">Project Spotlight {{ $i }}</h5>
                        <p class="small text-muted"><i class="far fa-calendar-alt text-primary me-2"></i>01 Nov 2025</p>
                        <p>Explore how Bloc Infra is shaping sustainable infrastructure for the next generation.</p>
                        <a href="#" class="fw-bold">Read More <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            @endfor
        </div>
    </div>

</x-layout.app-layout>
