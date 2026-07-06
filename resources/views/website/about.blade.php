<x-website-layout 
    title="About Us | Bloc-Infra - Building the Future with Quality & Trust" 
    description="Discover how Bloc-Infra Pvt. Ltd. connects builders, contractors, and clients under one powerful digital platform. Trusted construction services in Kanpur." 
    keywords="about Bloc-Infra, construction technology, trusted contractors Kanpur, builder connection"
>

    {{-- PAGE HEADER --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
                {{ __('About Us') }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
                {{ __('Building the Future with Strength, Quality & Integrity') }}
            </p>
        </div>
    </div>

    {{-- WHO WE ARE --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img-wrap position-relative">
                        <img src="{{ asset('website/img/about.jpg') }}" class="img-fluid position-relative w-100" style="z-index: 2;" alt="{{ __('About Bloc Infra') }}">
                        <div class="about-img-frame"></div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <span class="text-uppercase fw-bold text-primary mb-2 d-inline-block" style="font-size: 13px; letter-spacing: 2px;">{{ __('WHO WE ARE') }}</span>
                    <h2 class="fw-bold text-uppercase mb-3 text-dark">{{ __('Engineered for Trust & Reliability') }}</h2>
                    <p class="text-secondary mb-3 lh-lg">
                        <strong>{{ __('Bloc Infra Pvt. Ltd.') }}</strong> {{ __('connects builders, contractors, and clients under one powerful digital platform. Whether you’re hiring skilled professionals, managing contractors, or planning a construction project — we make the process simple, transparent, and reliable.') }}
                    </p>
                    <p class="text-secondary mb-4 lh-lg">
                        {{ __('Our platform empowers seamless collaboration through verified contractors, project tracking tools, and professional consultation — ensuring that every project is completed with trust, quality, and efficiency.') }}
                    </p>
                    <a href="{{ route('website.contact') }}" class="btn btn-primary px-4 py-3 rounded-pill fw-bold shadow-sm">
                        {{ __('Contact Us') }}
                        <i class="fa-solid fa-arrow-right ms-2" style="font-size: 12px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- OUR SERVICES --}}
    <section class="py-6 bg-light" style="border-top: 1px solid rgba(0,0,0,0.03); border-bottom: 1px solid rgba(0,0,0,0.03);">
        <div class="container text-center">
            <h2 class="fw-bold text-uppercase mb-2 text-dark">{{ __('Our Services') }}</h2>
            <p class="text-muted mb-5 fw-medium">{{ __('Simplifying Construction. Empowering Connections.') }}</p>

            <div class="row g-4">
                @php
                    $services = [
                        [
                            'icon' => 'fa-handshake',
                            'title' => __('Contractor–Builder Networking'),
                            'desc' =>
                                __('Connect with verified contractors for every aspect of construction, from small repairs to large-scale projects.'),
                        ],
                        [
                            'icon' => 'fa-comments',
                            'title' => __('Project Consultation'),
                            'desc' => __('Receive expert advice on project planning, budgeting, and timelines.'),
                        ],
                        [
                            'icon' => 'fa-tasks',
                            'title' => __('Project Management Tools'),
                            'desc' =>
                                __('Manage documentation, schedules, and communication efficiently with our digital tools.'),
                        ],
                        [
                            'icon' => 'fa-headset',
                            'title' => __('User Support'),
                            'desc' =>
                                __('Access dedicated support for queries, troubleshooting, and contractor recommendations.'),
                        ],
                    ];
                @endphp

                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="card h-100 service-card-premium p-4">
                            <div class="service-icon-box">
                                <i class="fa-solid {{ $service['icon'] }} fs-3 text-primary"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2" style="font-size: 16px;">{{ $service['title'] }}</h5>
                            <p class="text-muted small mb-0 lh-base">{{ $service['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- MISSION & VISION --}}
    <section class="bg-dark text-light py-6" style="background-color: #0b0f19 !important;">
        <div class="container text-center">
            <div class="row g-5">
                @php
                    $mv = [
                        [
                            'icon' => 'fa-bullseye',
                            'title' => __('Our Mission'),
                            'desc' =>
                                __('To empower the construction community by creating a transparent, efficient, and reliable digital platform connecting users, builders, and contractors.'),
                        ],
                        [
                            'icon' => 'fa-lightbulb',
                            'title' => __('Our Vision'),
                            'desc' =>
                                __('To become the most trusted online hub for construction services, recognized for innovation, quality, and dependable partnerships.'),
                        ],
                        [
                            'icon' => 'fa-people-group',
                            'title' => __('Our Values'),
                            'desc' =>
                                __('Integrity • Innovation • Quality • Safety • Sustainability • Customer Satisfaction.'),
                        ],
                    ];
                @endphp

                @foreach ($mv as $item)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="mission-card text-center">
                            <div class="mission-icon-box">
                                <i class="fa-solid {{ $item['icon'] }} fs-4"></i>
                            </div>
                            <h4 class="fw-bold text-uppercase mb-3 text-white" style="font-size: 18px; letter-spacing: 1px;">{{ $item['title'] }}</h4>
                            <p class="small text-light mb-0 lh-lg" style="opacity: 0.85; font-size: 13px;">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CONTRACTOR DETAILS --}}
    <section class="py-6 bg-white">
        <div class="container text-center">
            <h2 class="fw-bold text-uppercase mb-2 text-dark">{{ __('Essential Contractor Details') }}</h2>
            <p class="text-muted mb-5 fw-medium">{{ __('Transparency and trust begin with clear professional information.') }}</p>

            <div class="row g-4 text-start">
                @php
                    $details = [
                        [
                            'title' => __('Contractor / Company Name'),
                            'desc' => __('Fundamental for identification and branding.'),
                        ],
                        [
                            'title' => __('Areas of Specialization'),
                            'desc' => __('Specify skills like plumbing, electrical, carpentry, or general contracting.'),
                        ],
                        ['title' => __('Service Regions'), 'desc' => __('List the cities or regions your company serves.')],
                        [
                            'title' => __('Portfolio / Project Showcase'),
                            'desc' =>
                                __('Share photos, descriptions, and testimonials from completed work to build client trust.'),
                        ],
                        [
                            'title' => __('Years in Business / Experience'),
                            'desc' => __('Highlight reliability and industry expertise.'),
                        ],
                        [
                            'title' => __('Ratings & Reviews'),
                            'desc' => __('Display client feedback and star ratings for transparency.'),
                        ],
                    ];
                @endphp

                @foreach ($details as $item)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="card h-100 detail-card-premium p-4">
                            <h5 class="fw-bold text-dark mb-2" style="font-size: 16px;">{{ $item['title'] }}</h5>
                            <p class="text-secondary small mb-0 lh-base">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BLOG & LEGAL --}}
    <section class="py-6 bg-light" style="border-top: 1px solid rgba(0,0,0,0.03);">
        <div class="container text-center">
            <div class="row justify-content-center g-4">
                <div class="col-md-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card h-100 service-card-premium p-4 text-center">
                        <div class="service-icon-box">
                            <i class="fa-solid fa-newspaper fs-3 text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ __('Blog / Insights') }}</h5>
                        <p class="text-muted small mb-0 lh-base">
                            {{ __('Stay updated with construction trends, educational guides, and company news.') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-5 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card h-100 service-card-premium p-4 text-center">
                        <div class="service-icon-box">
                            <i class="fa-solid fa-scale-balanced fs-3 text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ __('Legal') }}</h5>
                        <p class="text-muted small mb-0 lh-base">
                            {{ __('Review our') }} <a href="#" class="fw-bold text-primary">{{ __('Terms & Conditions') }}</a> {{ __('and') }}
                            <a href="#" class="fw-bold text-primary">{{ __('Privacy Policy') }}</a>
                            {{ __('to understand your rights and obligations.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-dark text-center text-white py-6 position-relative overflow-hidden" style="border-top: 1px solid rgba(255,255,255,0.05); background-color: #0d121f !important;">
        <div class="container position-relative" style="z-index: 2;">
            <h2 class="display-6 fw-bold text-uppercase mb-3 text-white">{{ __('Ready to Build Your Vision?') }}</h2>
            <p class="lead text-light mb-4 opacity-75">{{ __('Get in touch with us today and let our experts guide you through.') }}</p>
            <a href="{{ route('website.login') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg text-uppercase">
                {{ __('Request a Demo') }}
                <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    {{-- CUSTOM STYLES --}}
    <style>
        .py-6 {
            padding-top: 4rem !important;
            padding-bottom: 4rem !important;
        }

        .about-img-wrap {
            position: relative;
            padding: 15px;
        }
        .about-img-wrap img {
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .about-img-wrap:hover img {
            transform: scale(1.02);
        }
        .about-img-frame {
            position: absolute;
            top: 0;
            left: 0;
            right: 30px;
            bottom: 30px;
            border: 2px solid #b3d33c;
            border-radius: 16px;
            opacity: 0.4;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1;
        }
        .about-img-wrap:hover .about-img-frame {
            transform: translate(8px, 8px);
            opacity: 0.8;
        }

        /* Our Services Cards (Light theme) */
        .service-card-premium {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 16px !important;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.01);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .service-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.06);
            border-color: rgba(179, 211, 60, 0.3) !important;
        }
        .service-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(179, 211, 60, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            transition: all 0.4s ease;
        }
        .service-card-premium:hover .service-icon-box {
            background: #b3d33c;
        }
        .service-card-premium:hover .service-icon-box i {
            color: #000000 !important;
            transform: scale(1.1);
        }

        /* Mission & Vision (Dark Theme Cards) */
        .mission-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            padding: 35px 30px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
        }
        .mission-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(179, 211, 60, 0.4) !important;
            box-shadow: 0 12px 30px rgba(179, 211, 60, 0.15);
        }
        .mission-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: rgba(179, 211, 60, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #b3d33c;
            transition: all 0.4s ease;
        }
        .mission-card:hover .mission-icon-box {
            background: #b3d33c;
            color: #000000;
        }

        /* Contractor Essential Cards */
        .detail-card-premium {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 12px !important;
            background: #ffffff;
            box-shadow: 0 6px 15px rgba(0,0,0,0.01);
            transition: all 0.3s ease;
        }
        .detail-card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.05);
            border-color: rgba(179, 211, 60, 0.25) !important;
        }
    </style>

    {{-- JS --}}
    @push('scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
        <script>
            new WOW().init();
        </script>
    @endpush

</x-website-layout>
