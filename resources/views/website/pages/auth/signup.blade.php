<x-layout.app-layout>


    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow p-4 wow fadeInUp">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Create Your Account</h3>
                        <p class="text-muted mb-0">Register as Contractor or User</p>
                    </div>

                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" class="form-control border-dark-subtle" placeholder="Enter full name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" class="form-control border-dark-subtle" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Password</label>
                            <input type="password" class="form-control border-dark-subtle"
                                placeholder="Create password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Confirm Password</label>
                            <input type="password" class="form-control border-dark-subtle"
                                placeholder="Confirm password">
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4 text-center">
                            <label class="form-label fw-semibold text-dark mb-2">Register As</label>
                            <div class="d-flex justify-content-center gap-3">

                                <div>
                                    <input type="radio" class="btn-check" name="role" id="contractor"
                                        autocomplete="off" checked>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="contractor"
                                        style="border-color:#b3d33c;color:#000;">
                                        Contractor
                                    </label>
                                </div>

                                <div>
                                    <input type="radio" class="btn-check" name="role" id="user"
                                        autocomplete="off">
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="user"
                                        style="border-color:#b3d33c;color:#000;">
                                        User
                                    </label>
                                </div>

                            </div>
                        </div>

                        <!-- Optional CSS for better active style -->
                        <style>
                            /* Make active role button filled with brand color */
                            .btn-check:checked+label {
                                background-color: #b3d33c !important;
                                color: #000 !important;
                                box-shadow: none !important;
                            }

                            /* Hover effect for better UX */
                            label.btn:hover {
                                background-color: #b3d33c20;
                                /* faint green tint */
                            }
                        </style>


                        <button type="submit" class="btn w-100 py-2"
                            style="background-color:#b3d33c;color:#000;font-weight:600;">
                            Register
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Already have an account?</p>
                        <a href="{{ route('website.login') }}" class="fw-semibold text-decoration-none"
                            style="color:#b3d33c;">Login Here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app-layout>
