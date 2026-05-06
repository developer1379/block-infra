<x-website-layout>

    {{-- Page Header --}}
    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
            Construction Services
        </h1>
        <p class="lead mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s" style="color:#fff;">
            Building Strength, Quality, and Trust — One Project at a Time
        </p>
    </div>

    {{-- Intro Section --}}
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow"
                    alt="Bloc Infra Construction">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="text-uppercase fw-bold mb-3" style="color:#b3d33c;">What We Build</h2>
                <p class="fw-semibold text-dark mb-4">
                    <strong>Bloc Infra Pvt. Ltd.</strong> delivers end-to-end construction solutions that combine
                    innovation, sustainability, and engineering precision. From residential spaces to large-scale
                    industrial projects,
                    we ensure structural excellence and aesthetic appeal in every build.
                </p>
                <ul class="list-unstyled text-dark fw-semibold">
                    <li><i class="bi bi-check-circle-fill me-2" style="color:#b3d33c;"></i> Residential & Commercial
                        Complexes</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color:#b3d33c;"></i> Industrial Infrastructure
                    </li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color:#b3d33c;"></i> Institutional & Government
                        Projects</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color:#b3d33c;"></i> Customized Construction
                        Solutions</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Our Expertise --}}
    <div class="container-fluid bg-dark py-6 mt-5">
        <div class="container text-center">
            <h2 class="text-uppercase fw-bold mb-4" style="color:#b3d33c;">Our Construction Expertise</h2>
            <p class="fw-semibold text-light mb-5">
                We take pride in transforming ideas into concrete realities with accuracy, passion, and professionalism.
            </p>
            <div class="row g-4">
                <div class="col-md-3 wow zoomIn" data-wow-delay="0.2s">
                    <i class="bi bi-bricks fs-1 mb-3" style="color:#b3d33c;"></i>
                    <h5 class="fw-bold text-white">Civil Construction</h5>
                    <p class="text-light small">
                        From foundations to finish, we ensure quality, safety, and precision at every stage.
                    </p>
                </div>
                <div class="col-md-3 wow zoomIn" data-wow-delay="0.4s">
                    <i class="bi bi-tools fs-1 mb-3" style="color:#b3d33c;"></i>
                    <h5 class="fw-bold text-white">Structural Design</h5>
                    <p class="text-light small">
                        Our team designs durable and efficient structures with advanced modeling tools.
                    </p>
                </div>
                <div class="col-md-3 wow zoomIn" data-wow-delay="0.6s">
                    <i class="bi bi-hammer fs-1 mb-3" style="color:#b3d33c;"></i>
                    <h5 class="fw-bold text-white">Renovation & Restoration</h5>
                    <p class="text-light small">
                        Reviving existing spaces while preserving their legacy and improving performance.
                    </p>
                </div>
                <div class="col-md-3 wow zoomIn" data-wow-delay="0.8s">
                    <i class="bi bi-building fs-1 mb-3" style="color:#b3d33c;"></i>
                    <h5 class="fw-bold text-white">Project Management</h5>
                    <p class="text-light small">
                        Ensuring smooth project execution through planning, budgeting, and supervision.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Why Choose Us --}}
    <div class="container py-6">
        <div class="text-center mb-5 wow fadeInDown">
            <h2 class="text-uppercase fw-bold" style="color:#b3d33c;">Why Choose Bloc Infra</h2>
            <p class="fw-semibold text-dark">Experience. Excellence. Efficiency.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                <i class="bi bi-award fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Proven Quality</h5>
                <p class="text-secondary small">
                    Consistent delivery of high-quality materials and workmanship.
                </p>
            </div>
            <div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                <i class="bi bi-person-check fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Trusted Professionals</h5>
                <p class="text-secondary small">
                    Skilled engineers and craftsmen ensuring perfection in every detail.
                </p>
            </div>
            <div class="col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                <i class="bi bi-clock-history fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">On-Time Delivery</h5>
                <p class="text-secondary small">
                    We value your time and guarantee timely completion with no compromises.
                </p>
            </div>
            <div class="col-md-3 wow fadeInUp" data-wow-delay="0.8s">
                <i class="bi bi-gear-wide-connected fs-1 mb-3" style="color:#b3d33c;"></i>
                <h5 class="fw-bold text-dark">Technology Driven</h5>
                <p class="text-secondary small">
                    Implementing modern construction methods for sustainable development.
                </p>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="container-fluid bg-dark text-center py-5 mt-5 wow fadeInUp" data-wow-delay="0.2s">
        <h2 class="text-uppercase fw-bold text-white mb-3">Let's Build Something Extraordinary</h2>
        <p class="text-light mb-4">Partner with Bloc Infra for projects that stand the test of time.</p>
        <a href="{{ url('contact') }}" class="btn px-5 py-3 mt-2 fw-bold" style="background-color:#b3d33c;color:#000;">
            Get in Touch <i class="bi bi-arrow-right"></i>
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

</x-website-layout>

