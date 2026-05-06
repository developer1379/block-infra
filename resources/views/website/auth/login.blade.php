<x-website-layout>
    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow p-4 wow fadeInDown">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Login to Bloc Infra</h3>
                        <p class="text-muted mb-0">Access your account as a User or Contractor</p>
                    </div>
                    <form method="POST" action="{{ route('website.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control border-dark-subtle"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Password</label>
                            <input type="password" name="password" class="form-control border-dark-subtle"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small text-muted" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="small text-decoration-none" style="color:#b3d33c;">Forgot
                                Password?</a>
                        </div>
                        <button type="submit" class="btn w-100 py-2"
                            style="background-color:#b3d33c;color:#000;font-weight:600;">
                            Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Don't have an account?</p>
                        <a href="{{ route('website.signup') }}" class="fw-semibold text-decoration-none"
                            style="color:#b3d33c;">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>

