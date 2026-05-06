<x-website-layout>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">Project Management</h1>
        <p class="text-white-50">Ensuring seamless execution through precision, discipline, and transparency.</p>
    </div>

    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="{{ asset('website/img/construction.jpg') }}" class="img-fluid rounded shadow" alt="Project Management">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <h2 class="fw-bold text-dark mb-3">Expert Project Management Services</h2>
                <p class="text-secondary">
                    We specialize in strategic planning, scheduling, budgeting, and resource allocation to deliver
                    projects on time, within budget, and beyond expectations.
                </p>
                <ul class="text-dark fw-semibold">
                    <li>End-to-End Project Planning</li>
                    <li>Risk & Cost Control</li>
                    <li>Progress Tracking & Reporting</li>
                    <li>Quality and Compliance Oversight</li>
                </ul>
                <a href="{{ route('website.contact') }}" class="btn mt-3 px-4 py-2" style="background-color:#b3d33c;color:#000;font-weight:600;">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

</x-website-layout>

