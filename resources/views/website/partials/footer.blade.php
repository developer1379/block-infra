<!-- Footer Start -->
<div class="footer container-fluid position-relative bg-dark bg-light-radial text-white-50 py-5 px-5">
    <div class="row g-5">
        <div class="col-lg-6 pe-lg-5">
            <a href="{{ route('website.home') }}" class="navbar-brand">
                <h1 class="m-0 display-5 text-uppercase text-white">
                    <i class="bi bi-building me-2" style="color:#b3d33c;"></i>BLOC INFRA
                </h1>
            </a>
            <p class="mt-3">
                {{ __('Bloc Infra is a leading construction and infrastructure company based in Kanpur, delivering high-quality residential, commercial, and industrial projects with innovation, sustainability, and precision.') }}
            </p>
            <p class="mb-1"><i class="fa fa-map-marker-alt me-2" style="color:#b3d33c;"></i>{{ __('Flat No. 202, Plot No. 674, Vishambhar Sadan, Vikas Nagar, Kanpur 208024') }}</p>
            <p class="mb-1"><i class="fa fa-phone-alt me-2" style="color:#b3d33c;"></i>+91 73111 22392</p>
            <p><i class="fa fa-envelope me-2" style="color:#b3d33c;"></i>info@blocinfra.com</p>
            <div class="d-flex justify-content-start mt-3">
                <a class="btn btn-sm btn-primary btn-square rounded-0 me-2"
                    style="background-color:#b3d33c;border:none;color:#000;" href="#"><i
                        class="fab fa-twitter"></i></a>
                <a class="btn btn-sm btn-primary btn-square rounded-0 me-2"
                    style="background-color:#b3d33c;border:none;color:#000;" href="#"><i
                        class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm btn-primary btn-square rounded-0 me-2"
                    style="background-color:#b3d33c;border:none;color:#000;" href="#"><i
                        class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-sm btn-primary btn-square rounded-0"
                    style="background-color:#b3d33c;border:none;color:#000;" href="#"><i
                        class="fab fa-instagram"></i></a>
            </div>
        </div>

        <div class="col-lg-6 ps-lg-5">
            <div class="row g-4">
                <div class="col-sm-6">
                    <h4 class="text-white text-uppercase mb-3">{{ __('Quick Links') }}</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-white-50 mb-2" href="{{ route('website.home') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Home') }}</a>
                        <a class="text-white-50 mb-2" href="{{ route('website.about') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('About Us') }}</a>
                        <a class="text-white-50 mb-2" href="#services"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Our Services') }}</a>
                        <a class="text-white-50 mb-2" href="#projects"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Projects') }}</a>
                        <a class="text-white-50" href="{{ route('website.contact') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Contact Us') }}</a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <h4 class="text-white text-uppercase mb-3">{{ __('Popular Links') }}</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-white-50 mb-2" href="{{ route('website.construction') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Residential') }}</a>
                        <a class="text-white-50 mb-2" href="{{ route('website.construction') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Commercial') }}</a>
                        <a class="text-white-50 mb-2" href="{{ route('website.infrastructure') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Infrastructure') }}</a>
                        <a class="text-white-50 mb-2" href="{{ route('website.construction') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Renovation') }}</a>
                        <a class="text-white-50" href="{{ route('website.blog.index') }}"><i class="fa fa-angle-right me-2"
                                style="color:#b3d33c;"></i>{{ __('Blog') }}</a>
                    </div>
                </div>

                <div class="col-sm-12">
                    <h4 class="text-white text-uppercase mb-3">{{ __('Newsletter') }}</h4>
                    <div class="w-100">
                        <form action="#" method="POST" class="input-group">
                            @csrf
                            <input type="email" class="form-control border-light bg-transparent text-light"
                                style="padding: 12px 18px;" placeholder="{{ __('Your Email Address') }}" required>
                            <button class="btn px-4" style="background-color:#b3d33c;color:#000;">{{ __('Sign Up') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg-dark text-white border-top mt-0 px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between">
        <div class="py-3 px-4 text-center text-md-start small">
            <p class="mb-0">&copy; <span style="color:#b3d33c;">{{ __('Bloc Infra') }}</span>. {{ __('All Rights Reserved.') }}</p>
        </div>
        <div class="py-3 px-4 text-center text-md-end small" style="background-color:#b3d33c;color:#000;">
            <p class="mb-0 text-dark">{{ __('Designed by') }} <a href="https://svinfotech.co.in" class="text-dark fw-bold">SV Infotech</a>
            </p>
        </div>
    </div>
</div>
<!-- Footer End -->
