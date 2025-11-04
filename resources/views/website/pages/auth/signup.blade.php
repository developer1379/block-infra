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
                                        value="contractor" autocomplete="off" checked>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="contractor"
                                        style="border-color:#b3d33c;color:#000;">Contractor</label>
                                </div>
                                <div>
                                    <input type="radio" class="btn-check" name="role" id="user" value="user"
                                        autocomplete="off">
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="user"
                                        style="border-color:#b3d33c;color:#000;">User</label>
                                </div>
                            </div>
                        </div>

                        <!-- Contractor Category (Dynamic Field) -->
                        <div class="mb-3" id="contractorCategoryField">
                            <label class="form-label fw-semibold text-dark">Contractor Category</label>
                            <select class="form-select border-dark-subtle">
                                <option selected disabled>Select Category</option>

                                <optgroup label="Building & Civil Works">
                                    <option value="civil">Civil Construction</option>
                                    <option value="structural">Structural Contractor</option>
                                    <option value="road">Road & Highway Contractor</option>
                                    <option value="bridge">Bridge & Infrastructure Contractor</option>
                                </optgroup>

                                <optgroup label="Mechanical, Electrical & Plumbing (MEP)">
                                    <option value="electrical">Electrical Contractor</option>
                                    <option value="mechanical">Mechanical / HVAC Contractor</option>
                                    <option value="plumbing">Plumbing & Sanitation</option>
                                    <option value="fire">Fire Safety Systems</option>
                                </optgroup>

                                <optgroup label="Finishing & Design">
                                    <option value="painting">Painting & Finishing</option>
                                    <option value="interior">Interior Design & Fit-out</option>
                                    <option value="tiling">Tiling & Flooring</option>
                                    <option value="carpentry">Carpentry & Joinery</option>
                                </optgroup>

                                <optgroup label="Specialized Works">
                                    <option value="landscaping">Landscaping & Exterior Works</option>
                                    <option value="waterproofing">Waterproofing & Insulation</option>
                                    <option value="solar">Solar & Renewable Installations</option>
                                    <option value="demolition">Demolition & Site Preparation</option>
                                </optgroup>
                            </select>
                        </div>

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

    <!-- Styles -->
    <style>
        .btn-check:checked+label {
            background-color: #b3d33c !important;
            color: #000 !important;
            box-shadow: none !important;
        }

        label.btn:hover {
            background-color: #b3d33c20;
        }
    </style>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contractorRadio = document.getElementById('contractor');
            const userRadio = document.getElementById('user');
            const categoryField = document.getElementById('contractorCategoryField');

            function toggleCategoryField() {
                if (contractorRadio.checked) {
                    categoryField.style.display = 'block';
                } else {
                    categoryField.style.display = 'none';
                }
            }

            contractorRadio.addEventListener('change', toggleCategoryField);
            userRadio.addEventListener('change', toggleCategoryField);

            // Initialize on load
            toggleCategoryField();
        });
    </script>
</x-layout.app-layout>
