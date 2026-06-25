<x-website-layout>

    {{-- Page Header --}}
    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
            {{ __('Project Management') }}
        </h1>
        <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
            {{ __('Ensuring seamless execution through precision, discipline, and transparency.') }}
        </p>
    </div>

    {{-- Intro Section --}}
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="position-relative">
                    <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow-lg" alt="{{ __('Project Management') }}">
                    <div class="position-absolute bottom-0 end-0 bg-primary p-3 rounded-start text-dark fw-bold" style="font-size: 14px;">
                        {{ __('Digital-First Workflows') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <span class="text-uppercase fw-bold mb-2 text-primary" style="font-size: 13px; letter-spacing: 2px;">{{ __('OPERATIONAL EFFICIENCY') }}</span>
                <h2 class="fw-bold text-dark mb-4">{{ __('Expert Project Management Services') }}</h2>
                <p class="text-secondary lh-lg mb-4">
                    {{ __('We specialize in strategic planning, scheduling, budgeting, and resource allocation to deliver projects on time, within budget, and beyond expectations. Our dedicated project managers coordinate closely with builders, site supervisors, and contractors to smooth out bottlenecks.') }}
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-history text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('On-Time Handovers') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-check text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Strict Quality Control') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-pie-chart text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Rigorous Cost Management') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-chat-left-text text-primary me-2 fs-5"></i>
                            <span class="text-dark fw-semibold">{{ __('Unified Communication') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Capabilities Grid --}}
    <div class="container-fluid bg-light py-6 my-5 border-top border-bottom">
        <div class="container text-center">
            <h2 class="text-uppercase fw-bold mb-3" style="color:#b3d33c;">{{ __('Our PM Scope') }}</h2>
            <p class="text-muted mb-5 max-w-600 mx-auto">{{ __('We manage execution complexities so that you can focus on scaling your core development.') }}</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-calendar-range fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Timeline & Scheduling') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Micro-scheduling key milestones using modern tools to avoid delay penalties.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-wallet2 fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Budgeting & Cost') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Optimizing material purchasing cycles and managing labor costs to prevent overruns.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-clipboard2-pulse fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Quality & Safety') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Ensuring structural parameters comply with state codes and site safety mandates.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="service-item text-center h-100 p-4">
                        <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3 text-dark">{{ __('Subcontractor Audits') }}</h5>
                        <p class="text-muted small mb-0">{{ __('Qualifying, scheduling, and auditing skilled task forces and raw logistics on site.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Workflow process --}}
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold text-dark">{{ __('Methodology & Execution') }}</h2>
            <p class="text-muted">{{ __('How we steer your project from initial brief to formal keys handover.') }}</p>
        </div>
        <div class="row g-4 text-center justify-content-center">
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">01</h1>
                    <h5 class="fw-bold text-dark">{{ __('Planning & Briefing') }}</h5>
                    <p class="text-muted small">{{ __('Aligning with architect drawings, milestones, budget schemas, and materials requirements.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">02</h1>
                    <h5 class="fw-bold text-dark">{{ __('Procurement Setup') }}</h5>
                    <p class="text-muted small">{{ __('Auditing vendor bids, hiring vetted contractors, and setting up daily log frameworks.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">03</h1>
                    <h5 class="fw-bold text-dark">{{ __('Monitoring') }}</h5>
                    <p class="text-muted small">{{ __('Deploying site supervisors to log attendance, coordinate materials, and track tasks daily.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <h1 class="display-3 text-primary opacity-25 fw-black mb-1">04</h1>
                    <h5 class="fw-bold text-dark">{{ __('Handover') }}</h5>
                    <p class="text-muted small">{{ __('Completing standard audits, compliance runs, final billing clearance, and keys handover.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="container-fluid bg-dark text-center py-5 mt-5">
        <h2 class="text-uppercase fw-bold text-white mb-3">{{ __('Seeking Hassle-Free Project Management?') }}</h2>
        <p class="text-light-50 mb-4">{{ __('Let us streamline workflows, manage budgets, and enforce structural benchmarks.') }}</p>
        <a href="{{ route('website.contact') }}" class="btn btn-primary px-5 py-3 rounded-pill">
            {{ __('Contact Us') }} <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

</x-website-layout>
