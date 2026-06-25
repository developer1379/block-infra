<x-website-layout>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">{{ __('Contact Us') }}</h1>
        <p class="text-white-50">{{ __('Let’s build something extraordinary together.') }}</p>
    </div>

    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <h3 class="fw-bold text-dark mb-4">{{ __('Get In Touch') }}</h3>
                <p class="text-secondary">{{ __('Reach us via the details below or fill out the contact form.') }}</p>
                <p><i class="bi bi-geo-alt me-2" style="color:#b3d33c;"></i> {{ __('Flat No. 202, Plot No. 674, Vishambhar Sadan, Vikas Nagar, Kanpur') }}</p>
                <p><i class="bi bi-telephone me-2" style="color:#b3d33c;"></i> +91 73111 22392</p>
                <p><i class="bi bi-envelope me-2" style="color:#b3d33c;"></i> info@blocinfra.com</p>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control border-dark" placeholder="{{ __('Your Name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control border-dark" placeholder="{{ __('Your Email') }}" required>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control border-dark" placeholder="{{ __('Subject') }}">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control border-dark" rows="4" placeholder="{{ __('Message') }}"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn w-100 py-2"
                                style="background-color:#b3d33c;color:#000;font-weight:600;">{{ __('Send Message') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-website-layout>
