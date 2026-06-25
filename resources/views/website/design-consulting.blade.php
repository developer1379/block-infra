<x-website-layout>

    {{-- Page Header --}}
    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
            {{ __('Design & Consulting') }}
        </h1>
        <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
            {{ __('Transforming ideas into innovative, sustainable design solutions.') }}
        </p>
    </div>

    {{-- Intro Section --}}
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="position-relative">
                    <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow-lg" alt="{{ __('Design & Consulting') }}">
                    <div class="position-absolute bottom-0 end-0 bg-primary p-3 rounded-start text-dark fw-bold" style="font-size: 14px;">
                        {{ __('Modern Architecture & Modeling') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <span class="text-uppercase fw-bold mb-2 text-primary" style="font-size: 13px; letter-spacing: 2px;">{{ __('CREATIVE PLANNING') }}</span>
                <h2 class="fw-bold text-dark mb-4">{{ __('Innovative Design & Expert Consulting') }}</h2>
                <p class="text-secondary lh-lg mb-4">
                    {{ __('Our experienced architects and consultants deliver tailored design and planning solutions for residential, commercial, and industrial spaces — ensuring functionality and aesthetics in harmony. We focus on cost-efficient, green-building designs that fulfill municipal regulations.') }}
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-palette text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Aesthetic Spatial Designs') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calculator-fill text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Accurate Load Calculations') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-bounding-box-circles text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('3D Visualizations') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-flower2 text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Green Building Code') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Capabilities Grid --}}
    <div class="container-fluid bg-light py-6 my-5 border-top border-bottom">
        <div class="container text-center">
            <h2 class="text-uppercase fw-bold mb-3" style="color:#b3d33c;">{{ __('Our Creative Specialties') }}</h2>
            <p class="text-muted mb-5 max-w-600 mx-auto">{{ __('Blending visual elements with hard engineering math to create constructible masterworks.') }}</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-vector-pen fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Architectural Design') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Modern spatial layouts, elevation concepts, and floor plans prioritizing natural ventilation.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-layout-wtf fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Structural Engineering') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Designing highly durable columns, beams, foundations, and slab modeling to withstand stresses.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-vr fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('3D Rendering & VR') }}</h5>
                        <p class="text-muted small mb-0">{{ __('High-definition 3D rendering walkthroughs helping clients visualize spaces prior to construction.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-leaf fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Eco-Consulting') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Advising on rainwater harvesting, solar integration, and low-carbon materials usage.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Workflow process --}}
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold text-dark">{{ __('The Consulting Method') }}</h2>
            <p class="text-muted">{{ __('How we shape design abstractions into concrete, constructible plans.') }}</p>
        </div>
        <div class="row g-4 text-center justify-content-center">
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">01</h1>
                    <h5 class="fw-bold text-dark">{{ __('Discovery & Needs') }}</h5>
                    <p class="text-muted small">{{ __('Initial interviews mapping out spatial usage, style expectations, budget parameters, and preferences.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">02</h1>
                    <h5 class="fw-bold text-dark">{{ __('Concept Development') }}</h5>
                    <p class="text-muted small">{{ __('Iterating conceptual sketches, layout variations, and architectural theme styles for review.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">03</h1>
                    <h5 class="fw-bold text-dark">{{ __('Engineering Modeling') }}</h5>
                    <p class="text-muted small">{{ __('Converting approved drawings into math-verified structural, plumbing, and electrical maps.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">04</h1>
                    <h5 class="fw-bold text-dark">{{ __('Final Tender Sheets') }}</h5>
                    <p class="text-muted small">{{ __('Generating clean bills of quantities, architectural prints, and structural specs ready for build.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="container-fluid bg-dark text-center py-5 mt-5">
        <h2 class="text-uppercase fw-bold text-white mb-3">{{ __('Ready to Design Your Spaces?') }}</h2>
        <p class="text-light-50 mb-4">{{ __('Book a consultation session with our design leaders and structural engineers.') }}</p>
        <a href="{{ route('website.contact') }}" class="btn btn-primary px-5 py-3 rounded-pill">
            {{ __('Schedule Consultation') }} <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

</x-website-layout>
