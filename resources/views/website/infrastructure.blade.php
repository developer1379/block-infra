<x-website-layout 
    title="Infrastructure Services | Bloc-Infra - Delivering Engineering Excellence" 
    description="Specialized infrastructure development services in Kanpur. Road building, heavy civil engineering, and public works with world-class quality." 
    keywords="infrastructure services, road construction, civil engineering, public works Kanpur, infrastructure developers"
>

    {{-- Page Header --}}
    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
            {{ __('Infrastructure') }}
        </h1>
        <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
            {{ __('Building the backbone of tomorrow’s cities with innovation and trust.') }}
        </p>
    </div>

    {{-- Intro Section --}}
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="position-relative">
                    <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow-lg" alt="{{ __('Infrastructure') }}">
                    <div class="position-absolute bottom-0 end-0 bg-primary p-3 rounded-start text-dark fw-bold" style="font-size: 14px;">
                        {{ __('ISO 9001:2015 Certified') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <span class="text-uppercase fw-bold mb-2 text-primary" style="font-size: 13px; letter-spacing: 2px;">{{ __('CIVIL ENGINEERING EXCELLENCE') }}</span>
                <h2 class="fw-bold text-dark mb-4">{{ __('Comprehensive Infrastructure Solutions') }}</h2>
                <p class="text-secondary lh-lg mb-4">
                    {{ __('Bloc Infra delivers state-of-the-art infrastructure development — from highways and bridges to water systems and smart urban projects — engineered for long-term performance and sustainability. We merge technical prowess with structured governance to ensure safety and precision on all fronts.') }}
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Highways & Expressways') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Smart Grid Integration') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Water & Sewage Utilities') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Bridges & Flyovers') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Capabilities Grid --}}
    <div class="container-fluid bg-light py-6 my-5 border-top border-bottom">
        <div class="container text-center">
            <h2 class="text-uppercase fw-bold mb-3" style="color:#b3d33c;">{{ __('Our Scope of Works') }}</h2>
            <p class="text-muted mb-5 max-w-600 mx-auto">{{ __('We deliver scalable civil structures designed to serve communities for generations.') }}</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-road-spikes fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Roads & Transport') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Design and construction of national highways, state expressways, and urban transit systems.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-droplet-half fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Water Engineering') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Establishing smart water purification systems, distribution networks, and drainage systems.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-cpu fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Smart Utilities') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Underground cabling, fiber ducting, street grid integrations, and environmental setups.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-bezier2 fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Structural Engineering') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Building long-span bridges, flyovers, overpasses, and complex elevated road networks.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Workflow process --}}
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold text-dark">{{ __('The Infrastructure Lifecycle') }}</h2>
            <p class="text-muted">{{ __('How we deliver large-scale project execution with reliability.') }}</p>
        </div>
        <div class="row g-4 text-center justify-content-center">
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">01</h1>
                    <h5 class="fw-bold text-dark">{{ __('Feasibility') }}</h5>
                    <p class="text-muted small">{{ __('Rigorous land surveys, soil tests, and environmental feasibility studies.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">02</h1>
                    <h5 class="fw-bold text-dark">{{ __('Design & Approvals') }}</h5>
                    <p class="text-muted small">{{ __('Comprehensive structural modeling and securing necessary municipal permits.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">03</h1>
                    <h5 class="fw-bold text-dark">{{ __('Construction') }}</h5>
                    <p class="text-muted small">{{ __('Safe, efficient civil works monitored in real-time on our digital panel.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">04</h1>
                    <h5 class="fw-bold text-dark">{{ __('Commissioning') }}</h5>
                    <p class="text-muted small">{{ __('Final audits, safety checks, structural load tests, and formal handovers.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="container-fluid bg-dark text-center py-5 mt-5">
        <h2 class="text-uppercase fw-bold text-white mb-3">{{ __('Need a Robust Infrastructure Partner?') }}</h2>
        <p class="text-light-50 mb-4">{{ __('Let’s construct the future blocks of cities with trust and precision.') }}</p>
        <a href="{{ route('website.contact') }}" class="btn btn-primary px-5 py-3 rounded-pill">
            {{ __('Get in Touch') }} <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

</x-website-layout>
