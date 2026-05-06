<x-website-layout>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">Design & Consulting</h1>
        <p class="text-white-50">Transforming ideas into innovative, sustainable design solutions.</p>
    </div>

    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow" alt="Design & Consulting">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="fw-bold text-dark mb-3">Innovative Design & Expert Consulting</h2>
                <p class="text-secondary">
                    Our experienced architects and consultants deliver tailored design and planning solutions
                    for residential, commercial, and industrial spaces — ensuring functionality and aesthetics in harmony.
                </p>
                <ul class="text-dark fw-semibold">
                    <li>Architectural & Structural Design</li>
                    <li>Consulting for Smart Building Solutions</li>
                    <li>3D Modeling & Visualization</li>
                    <li>Value Engineering & Sustainability Consulting</li>
                </ul>
                <a href="{{ route('website.contact') }}" class="btn mt-3 px-4 py-2" style="background-color:#b3d33c;color:#000;font-weight:600;">
                    Schedule Consultation
                </a>
            </div>
        </div>
    </div>

</x-website-layout>

