<x-website-layout>

    {{-- PAGE HEADER --}}
    <section class="bg-dark text-center py-6 mb-5">
        <div class="container">
            <h1 class="display-5 fw-bold text-uppercase mb-2" style="color:#b3d33c;">About Us</h1>
            <p class="lead text-light fw-medium mb-0">Building the Future with Strength, Quality & Integrity</p>
        </div>
    </section>

    {{-- WHO WE ARE --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <img src="{{ asset('website/img/about.jpg') }}" class="img-fluid rounded shadow"
                        alt="About Bloc Infra">
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <h2 class="fw-bold text-uppercase mb-3" style="color:#b3d33c;">Who We Are</h2>
                    <p class="text-dark mb-3 lh-lg">
                        <strong>Bloc Infra Pvt. Ltd.</strong> connects builders, contractors, and clients under one
                        powerful digital platform.
                        Whether you’re hiring skilled professionals, managing contractors, or planning a construction
                        project —
                        we make the process simple, transparent, and reliable.
                    </p>
                    <p class="text-dark mb-4 lh-lg">
                        Our platform empowers seamless collaboration through verified contractors, project tracking
                        tools, and professional consultation —
                        ensuring that every project is completed with trust, quality, and efficiency.
                    </p>
                    <a href="{{ url('contact') }}" class="btn px-4 py-2 fw-bold shadow-sm"
                        style="background-color:#b3d33c;color:#000;">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    {{-- OUR SERVICES --}}
    <section class="py-6 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold text-uppercase mb-3" style="color:#b3d33c;">Our Services</h2>
            <p class="text-muted mb-5">Simplifying Construction. Empowering Connections.</p>

            <div class="row g-4">
                @php
                    $services = [
                        [
                            'icon' => 'fa-handshake',
                            'title' => 'Contractor–Builder Networking',
                            'desc' =>
                                'Connect with verified contractors for every aspect of construction, from small repairs to large-scale projects.',
                        ],
                        [
                            'icon' => 'fa-comments',
                            'title' => 'Project Consultation',
                            'desc' => 'Receive expert advice on project planning, budgeting, and timelines.',
                        ],
                        [
                            'icon' => 'fa-tasks',
                            'title' => 'Project Management Tools',
                            'desc' =>
                                'Manage documentation, schedules, and communication efficiently with our digital tools.',
                        ],
                        [
                            'icon' => 'fa-headset',
                            'title' => 'User Support',
                            'desc' =>
                                'Access dedicated support for queries, troubleshooting, and contractor recommendations.',
                        ],
                    ];
                @endphp

                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="card h-100 border-0 shadow-sm p-4 transition hover-lift">
                            <div class="mb-3">
                                <i class="fa-solid {{ $service['icon'] }} fs-2" style="color:#b3d33c;"></i>
                            </div>
                            <h5 class="fw-semibold text-dark mb-2">{{ $service['title'] }}</h5>
                            <p class="text-muted small mb-0 lh-base">{{ $service['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- MISSION & VISION --}}
    <section class="bg-dark text-light py-6">
        <div class="container text-center">
            <div class="row g-5">
                @php
                    $mv = [
                        [
                            'icon' => 'fa-bullseye',
                            'title' => 'Our Mission',
                            'desc' =>
                                'To empower the construction community by creating a transparent, efficient, and reliable digital platform connecting users, builders, and contractors.',
                        ],
                        [
                            'icon' => 'fa-lightbulb',
                            'title' => 'Our Vision',
                            'desc' =>
                                'To become the most trusted online hub for construction services, recognized for innovation, quality, and dependable partnerships.',
                        ],
                        [
                            'icon' => 'fa-people-group',
                            'title' => 'Our Values',
                            'desc' =>
                                'Integrity • Innovation • Quality • Safety • Sustainability • Customer Satisfaction.',
                        ],
                    ];
                @endphp

                @foreach ($mv as $item)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="p-4 border border-secondary rounded-3 h-100 bg-black bg-opacity-25">
                            <i class="fa-solid {{ $item['icon'] }} fs-2 mb-3" style="color:#b3d33c;"></i>
                            <h4 class="fw-bold text-uppercase mb-3 text-light">{{ $item['title'] }}</h4>
                            <p class="small text-light mb-0 lh-lg">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CONTRACTOR DETAILS --}}
    <section class="py-6">
        <div class="container text-center">
            <h2 class="fw-bold text-uppercase mb-3" style="color:#b3d33c;">Essential Contractor Details</h2>
            <p class="text-muted mb-5">Transparency and trust begin with clear professional information.</p>

            <div class="row g-4 text-start">
                @php
                    $details = [
                        [
                            'title' => 'Contractor / Company Name',
                            'desc' => 'Fundamental for identification and branding.',
                        ],
                        [
                            'title' => 'Areas of Specialization',
                            'desc' => 'Specify skills like plumbing, electrical, carpentry, or general contracting.',
                        ],
                        ['title' => 'Service Regions', 'desc' => 'List the cities or regions your company serves.'],
                        [
                            'title' => 'Portfolio / Project Showcase',
                            'desc' =>
                                'Share photos, descriptions, and testimonials from completed work to build client trust.',
                        ],
                        [
                            'title' => 'Years in Business / Experience',
                            'desc' => 'Highlight reliability and industry expertise.',
                        ],
                        [
                            'title' => 'Ratings & Reviews',
                            'desc' => 'Display client feedback and star ratings for transparency.',
                        ],
                    ];
                @endphp

                @foreach ($details as $item)
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="card h-100 border-0 shadow-sm p-4 transition hover-lift bg-white">
                            <h5 class="fw-semibold text-dark mb-2">{{ $item['title'] }}</h5>
                            <p class="text-dark small mb-0 lh-base">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BLOG & LEGAL --}}
    <section class="py-6 bg-light">
        <div class="container text-center">
            <div class="row justify-content-center g-4">
                <div class="col-md-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card border-0 shadow-sm p-4 h-100 hover-lift">
                        <i class="fa-solid fa-newspaper fs-2 mb-3" style="color:#b3d33c;"></i>
                        <h5 class="fw-semibold text-dark mb-2">Blog / Insights</h5>
                        <p class="text-muted small mb-0 lh-base">
                            Stay updated with construction trends, educational guides, and company news.
                        </p>
                    </div>
                </div>
                <div class="col-md-5 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card border-0 shadow-sm p-4 h-100 hover-lift">
                        <i class="fa-solid fa-scale-balanced fs-2 mb-3" style="color:#b3d33c;"></i>
                        <h5 class="fw-semibold text-dark mb-2">Legal</h5>
                        <p class="text-muted small mb-0 lh-base">
                            Review our <a href="#" class="text-decoration-none" style="color:#b3d33c;">Terms &
                                Conditions</a> and
                            <a href="#" class="text-decoration-none" style="color:#b3d33c;">Privacy Policy</a>
                            to understand your rights and obligations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-dark text-center text-white py-6">
        <div class="container">
            <h2 class="fw-bold text-uppercase mb-3">Ready to Build Your Vision?</h2>
            <a href="{{ url('request-demo') }}" class="btn px-5 py-3 mt-3 fw-bold shadow-sm"
                style="background-color:#b3d33c;color:#000;">Request a Demo
                <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
    </section>

    {{-- CUSTOM STYLES --}}
    <style>
        .py-6 {
            padding-top: 4rem !important;
            padding-bottom: 4rem !important;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
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

