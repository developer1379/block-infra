<x-website-layout>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">{{ __('Infrastructure') }}</h1>
        <p class="text-white-50">{{ __('Building the backbone of tomorrow’s cities with innovation and trust.') }}</p>
    </div>

    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow"
                    alt="{{ __('Infrastructure') }}">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="fw-bold text-dark mb-3">{{ __('Comprehensive Infrastructure Solutions') }}</h2>
                <p class="text-secondary">
                    {{ __('Bloc Infra delivers state-of-the-art infrastructure development — from highways and bridges to water systems and smart urban projects — engineered for long-term performance and sustainability.') }}
                </p>
                <ul class="text-dark fw-semibold">
                    <li>{{ __('Urban & Rural Infrastructure Projects') }}</li>
                    <li>{{ __('Smart City Development') }}</li>
                    <li>{{ __('Industrial Zone Planning') }}</li>
                    <li>{{ __('Water Supply & Sanitation') }}</li>
                </ul>
                <a href="{{ route('website.contact') }}" class="btn mt-3 px-4 py-2"
                    style="background-color:#b3d33c;color:#000;font-weight:600;">
                    {{ __('Get in Touch') }}
                </a>
            </div>
        </div>
    </div>

</x-website-layout>
