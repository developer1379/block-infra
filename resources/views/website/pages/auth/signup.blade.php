<x-layout.app-layout>
    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow p-4 wow fadeInUp">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c;">Create Your Account</h3>
                        <p class="text-muted mb-0">Register as Contractor or User</p>
                    </div>

                    {{-- ✅ Registration Form --}}
                    <form method="POST" action="{{ route('website.register.submit') }}">
                        @csrf

                        {{-- Full Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control border-dark-subtle" placeholder="Enter full name" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control border-dark-subtle" placeholder="Enter email" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Password</label>
                            <input type="password" name="password" class="form-control border-dark-subtle"
                                placeholder="Create password" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control border-dark-subtle"
                                placeholder="Confirm password" required>
                        </div>

                        {{-- Role Selection --}}
                        <div class="mb-4 text-center">
                            <label class="form-label fw-semibold text-dark mb-2">Register As</label>
                            <div class="d-flex justify-content-center gap-3">
                                <div>
                                    <input type="radio" class="btn-check" name="role" id="contractor"
                                        value="contractor" autocomplete="off"
                                        {{ old('role', 'contractor') === 'contractor' ? 'checked' : '' }}>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="contractor"
                                        style="border-color:#b3d33c;color:#000;">Contractor</label>
                                </div>
                                <div>
                                    <input type="radio" class="btn-check" name="role" id="user" value="user"
                                        autocomplete="off" {{ old('role') === 'user' ? 'checked' : '' }}>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="user"
                                        style="border-color:#b3d33c;color:#000;">User</label>
                                </div>
                            </div>
                        </div>

                        {{-- Contractor Category (only when contractor selected) --}}
                        <div class="mb-3" id="contractorCategoryField">
                            <label class="form-label fw-semibold text-dark">Contractor Category</label>
                            <select name="contractor_category" class="form-select border-dark-subtle">
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
                            @error('contractor_category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit --}}
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

    {{-- Inline Styles --}}
    <style>
        .btn-check:checked+label {
            background-color: #b3d33c !important;
            color: #000 !important;
            box-shadow: none !important;
        }

        label.btn:hover {
            background-color: #b3d33c20;
        }

        small.text-danger {
            display: block;
            margin-top: 3px;
        }
    </style>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contractorRadio = document.getElementById('contractor');
            const userRadio = document.getElementById('user');
            const categoryField = document.getElementById('contractorCategoryField');

            function toggleCategoryField() {
                categoryField.style.display = contractorRadio.checked ? 'block' : 'none';
            }

            contractorRadio.addEventListener('change', toggleCategoryField);
            userRadio.addEventListener('change', toggleCategoryField);
            toggleCategoryField();
        });
    </script>
</x-layout.app-layout>
