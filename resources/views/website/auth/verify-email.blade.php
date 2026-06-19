<x-website-layout>
    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow p-4 wow fadeInDown">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Verify Email</h3>
                        <p class="text-muted mb-0">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center mb-3" role="alert">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn w-100 py-2 mb-3"
                            style="background-color:#b3d33c;color:#000;font-weight:600;">
                            Resend Verification Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100 py-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
