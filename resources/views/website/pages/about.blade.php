<x-layout.app-layout>

    {{-- Page Header --}}
    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
            About Us
        </h1>
        <p class="lead mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s" style="color:#fff;">
            Building the Future with Strength, Quality & Integrity
        </p>
    </div>

    {{-- About Section --}}
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/about.jpg') }}" class="img-fluid rounded shadow" alt="About Bloc Infra">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="text-uppercase fw-bold mb-3" style="color:#b3d33c;">Who We Are</h2>
                <p class="fw-semibold text-dark mb-4">
                    <strong>Bloc Infra Pvt. Ltd.</strong> is a Kanpur-based construction and infrastructure development
                    company focused on delivering excellence through innovation, sustainability, and technology.
                    We specialize in residential, commercial, and industrial projects, setting benchmarks in quality and
                    reliability.
                </p>
                <p class="fw-semibold text-dark mb-4">
                    Our expert engineers and designers ensure every project reflects our core values — commitment,
                    transparency, and craftsmanship. At Bloc Infra, we don’t just build structures; we build trust.
                </p>
                <a href="{{ url('contact') }}" class="btn px-4 py-2 wow fadeInUp fw-bold" data-wow-delay="0.6s"
                    style="background-color:#b3d33c;color:#000;">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

    {{-- Mission Vision Values --}}
    <div class="container-fluid bg-dark py-6 mt-5">
        <div class="container text-center">
            <div class="row g-5">
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="p-4 border border-secondary rounded h-100">
                        <i class="bi bi-bullseye fs-1 mb-3" style="color:#b3d33c;"></i>
                        <h4 class="text-uppercase text-white fw-bold mb-3">Our Mission</h4>
                        <p class="fw-semibold text-light mb-0">
                            To provide sustainable and innovative infrastructure solutions that empower progress and
                            enrich communities.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="p-4 border border-secondary rounded h-100">
                        <i class="bi bi-lightbulb fs-1 mb-3" style="color:#b3d33c;"></i>
                        <h4 class="text-uppercase text-white fw-bold mb-3">Our Vision</h4>
                        <p class="fw-semibold text-light mb-0">
                            To become a leading name in construction through innovation, integrity, and a relentless
                            pursuit of excellence.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="p-4 border border-secondary rounded h-100">
                        <i class="bi bi-people fs-1 mb-3" style="color:#b3d33c;"></i>
                        <h4 class="text-uppercase text-white fw-bold mb-3">Our Values</h4>
                        <p class="fw-semibold text-light mb-0">
                            Integrity | Innovation | Quality | Safety | Sustainability | Customer Satisfaction
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Why Choose Bloc Infra --}}
    <div class="container py-6">
        <div class="text-center mb-5 wow fadeInDown">
            <h2 class="text-uppercase fw-bold" style="color:#b3d33c;">Why Choose Bloc Infra</h2>
            <p class="fw-semibold text-dark">Your Reliable Partner in Infrastructure & Construction Excellence</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                <i class="bi bi-award fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Quality Assurance</h5>
                <p class="fw-semibold text-dark small">
                    Uncompromising focus on excellence and durability in every project.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                <i class="bi bi-gear fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Modern Technology</h5>
                <p class="fw-semibold text-dark small">
                    Leveraging advanced tools and digital methods for efficiency and precision.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                <i class="bi bi-people-fill fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Expert Team</h5>
                <p class="fw-semibold text-dark small">
                    Our experienced professionals are committed to delivering exceptional results.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.8s">
                <i class="bi bi-building fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Timely Delivery</h5>
                <p class="fw-semibold text-dark small">
                    Reliable project management ensures we deliver on time, every time.
                </p>
            </div>
        </div>
    </div>

    {{-- Call to Action --}}
    <div class="container-fluid bg-dark text-center py-5 mt-5 wow fadeInUp" data-wow-delay="0.2s">
        <h2 class="text-uppercase fw-bold text-white mb-3">Ready to Build Your Vision?</h2>
        <a href="{{ url('request-demo') }}" class="btn px-5 py-3 mt-3 fw-bold"
            style="background-color:#b3d33c;color:#000;">
            Request a Demo <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    {{-- WOW.js & Animate.css --}}
    @push('scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script>
            new WOW().init();
        </script>
    @endpush

</x-layout.app-layout>
