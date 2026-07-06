<x-website-layout 
    title="Digital Shramik | Bloc-Infra - Direct Labor Hiring Platform" 
    description="Hire skilled, semi-skilled, and verified construction workers directly. Empowering workers and simplifying hiring for contractors." 
    keywords="hire construction labor, digital shramik, construction workers, skilled labor Kanpur, worker verification"
>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">DigitalShramik</h1>
        <p class="text-white-50">Empowering labor management with technology-driven innovation.</p>
    </div>

    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow"
                    alt="DigitalShramik">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="fw-bold text-dark mb-3">Smart Workforce Management</h2>
                <p class="text-secondary">
                    Bloc Infra’s <strong>DigitalShramik</strong> is an innovative workforce management platform designed
                    for construction and infrastructure projects. It simplifies attendance, wage management, and site
                    reporting using real-time digital tracking.
                </p>
                <ul class="text-dark fw-semibold">
                    <li>Biometric & Face-based Attendance</li>
                    <li>Automated Salary & Shift Tracking</li>
                    <li>Centralized Workforce Data</li>
                    <li>Real-Time Site Monitoring Dashboard</li>
                </ul>
                <a href="{{ route('website.request-demo') }}" class="btn mt-3 px-4 py-2"
                    style="background-color:#b3d33c;color:#000;font-weight:600;">
                    Request a Demo
                </a>
            </div>
        </div>
    </div>

</x-website-layout>

