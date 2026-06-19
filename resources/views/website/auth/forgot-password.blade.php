<x-website-layout>
    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow p-4 wow fadeInDown">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Forgot Password</h3>
                        <p class="text-muted mb-0">Enter your email address to receive a password reset link.</p>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control border-dark-subtle"
                                placeholder="Enter your email" required autofocus>
                        </div>
                        <button type="submit" class="btn w-100 py-2"
                            style="background-color:#b3d33c;color:#000;font-weight:600;">
                            Send Password Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('website.login') }}" class="fw-semibold text-decoration-none"
                            style="color:#b3d33c;">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
