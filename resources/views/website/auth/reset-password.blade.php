<x-website-layout>
    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow p-4 wow fadeInDown">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Reset Password</h3>
                        <p class="text-muted mb-0">Enter your email and choose a new password.</p>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control border-dark-subtle"
                                placeholder="Enter your email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">New Password</label>
                            <input type="password" name="password" class="form-control border-dark-subtle"
                                placeholder="Enter new password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control border-dark-subtle"
                                placeholder="Confirm new password" required>
                        </div>

                        <button type="submit" class="btn w-100 py-2"
                            style="background-color:#b3d33c;color:#000;font-weight:600;">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
