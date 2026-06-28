<x-website-layout>
    <style>
        .login-card-premium {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 24px !important;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden;
            padding: 40px !important;
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

        /* Checkbox styling */
        .form-check-input:checked {
            background-color: #b3d33c !important;
            border-color: #b3d33c !important;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(179, 211, 60, 0.15) !important;
            border-color: #b3d33c !important;
        }
    </style>

    <div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 login-card-premium wow fadeInDown">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c; letter-spacing: 1px;">{{ __('Login to Bloc Infra') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Access your account as a User or Contractor') }}</p>
                    </div>
                    <form method="POST" action="{{ route('website.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="label-title mb-1 small">{{ __('Email Address') }}</label>
                            <input type="email" name="email" class="form-control"
                                placeholder="{{ __('Enter your email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="label-title mb-1 small">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ __('Enter your password') }}" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
                                <label class="form-check-label small text-muted" for="remember">{{ __('Remember me') }}</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="small fw-semibold text-decoration-none" style="color:#b3d33c;">{{ __('Forgot Password?') }}</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm">
                            {{ __('Login') }}
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(0,0,0,0.03);">
                        <p class="text-muted small mb-1">{{ __("Don't have an account?") }}</p>
                        <a href="{{ route('website.signup') }}" class="fw-bold text-decoration-none small text-uppercase"
                            style="color:#b3d33c; letter-spacing: 0.5px;">{{ __('Register Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
