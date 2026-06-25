<x-website-layout>

    <style>
        .contact-info-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            background: #ffffff;
            padding: 35px 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.01);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
        }

        .contact-info-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(4, 15, 40, 0.06);
            border-color: rgba(179, 211, 60, 0.35);
        }

        .contact-icon-box {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: rgba(179, 211, 60, 0.08);
            color: #b3d33c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            font-size: 26px;
            transition: all 0.4s ease;
        }

        .contact-info-card:hover .contact-icon-box {
            background: #b3d33c;
            color: #000000;
            transform: scale(1.05);
        }

        .contact-card-premium {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden;
        }

        .contact-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            padding: 28px 35px !important;
        }

        .form-control {
            padding: 14px 20px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background-color: #fafbfc;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #b3d33c;
            box-shadow: 0 0 0 4px rgba(179, 211, 60, 0.12);
        }

        .label-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .map-container {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 15px 40px rgba(0,0,0,0.02);
            height: 480px;
        }
    </style>

    {{-- Page Header --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
                {{ __('Contact Us') }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
                {{ __('Let’s build something extraordinary together.') }}
            </p>
        </div>
    </div>

    <div class="container py-5">
        
        {{-- Contact Info Cards (3 Columns) --}}
        <div class="row g-4 mb-5 text-center">
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="contact-info-card">
                    <div class="contact-icon-box">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ __('Our Office') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Flat No. 202, Plot No. 674, Vishambhar Sadan, Vikas Nagar, Kanpur 208024') }}</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="contact-info-card">
                    <div class="contact-icon-box">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ __('Call Us') }}</h5>
                    <p class="text-muted fw-bold small mb-1" style="color:#b3d33c;">+91 73111 22392</p>
                    <p class="text-muted small mb-0">{{ __('Mon - Sat: 9:00 AM - 6:00 PM') }}</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                <div class="contact-info-card">
                    <div class="contact-icon-box">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ __('Email Us') }}</h5>
                    <p class="text-muted fw-bold small mb-1" style="color:#b3d33c;">info@blocinfra.com</p>
                    <p class="text-muted small mb-0">support@blocinfra.com</p>
                </div>
            </div>
        </div>

        <div class="row g-5">
            {{-- CONTACT MAP (Left) --}}
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="map-container h-100">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3571.2185250493867!2d80.2974378!3d26.4809249!2m3!1f0!2f0!3f0!2m3!1i1024!2i768!4f13.1!3m3!1m2!1m3!1d3571.2185250493867!2d80.2974378!3d26.4809249!2sVikas%20Nagar%2C%20Kanpur%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
                        width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            {{-- CONTACT FORM CARD (Right) --}}
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <div class="card contact-card-premium shadow-sm">
                    <div class="card-header contact-header">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-envelope-paper me-2" style="color:#b3d33c;"></i>
                            {{ __('Send Us a Message') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="label-title mb-1 small">{{ __('Your Name') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('Your Name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="label-title mb-1 small">{{ __('Your Email') }}</label>
                                    <input type="email" class="form-control" placeholder="{{ __('Your Email') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="label-title mb-1 small">{{ __('Subject') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('Subject') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="label-title mb-1 small">{{ __('Message') }}</label>
                                    <textarea class="form-control" rows="4" placeholder="{{ __('Write your message here...') }}" required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary w-100 py-3 text-uppercase fw-bold rounded-pill shadow-sm" type="submit">
                                        <i class="bi bi-send me-2"></i> {{ __('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-website-layout>
