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
                                        {{ old('role') === 'contractor' ? 'checked' : '' }}>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="contractor"
                                        style="border-color:#b3d33c;color:#000;">Contractor</label>
                                </div>
                                <div>
                                    <input type="radio" class="btn-check" name="role" id="user" value="user"
                                        autocomplete="off" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                                    <label class="btn border border-2 px-4 py-2 fw-semibold" for="user"
                                        style="border-color:#b3d33c;color:#000;">User</label>
                                </div>
                            </div>
                        </div>

                        {{-- Contractor Extra Fields --}}
                        <div id="contractorFields">
                            {{-- Company Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Company Name</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}"
                                    class="form-control border-dark-subtle" placeholder="Enter company name">
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="form-control border-dark-subtle" placeholder="Enter phone number">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">City</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="form-control border-dark-subtle" placeholder="Enter city">
                                @error('city')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @php
                                $parentCategories = \App\Models\Category::query()
                                    ->with([
                                        'subcategories' => function ($q) {
                                            $q->where('is_active', 1)->orderBy('name');
                                        },
                                    ])
                                    ->whereNull('parent_id')
                                    ->where('is_active', 1)
                                    ->orderBy('name')
                                    ->get();
                            @endphp

                            {{-- Contractor Categories (Multiple Select) --}}
                            <div class="mb-3 form-group" id="contractorCategoryField">
                                <label class="form-label fw-semibold text-dark">Select Categories (Multiple)</label>

                                <select name="categories[]" class="form-select border-dark-subtle" multiple
                                    size="6">
                                    @foreach ($parentCategories as $parent)
                                        @php $children = $parent->subcategories; @endphp

                                        @if ($children->count())
                                            <optgroup label="{{ $parent->name }}">
                                                @foreach ($children as $child)
                                                    <option value="{{ $child->id }}"
                                                        @if (is_array(old('categories')) && in_array($child->id, old('categories'))) selected @endif>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $parent->id }}"
                                                @if (is_array(old('categories')) && in_array($parent->id, old('categories'))) selected @endif>
                                                {{ $parent->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                <small class="text-muted">Hold CTRL to select multiple.</small>

                                @error('categories')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

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

        #contractorFields {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contractorRadio = document.getElementById('contractor');
            const userRadio = document.getElementById('user');
            const contractorFields = document.getElementById('contractorFields');

            function toggleContractorFields() {
                contractorFields.style.display = contractorRadio.checked ? 'block' : 'none';
            }

            contractorRadio.addEventListener('change', toggleContractorFields);
            userRadio.addEventListener('change', toggleContractorFields);

            // 👇 ensures that user is selected by default on page load
            if (!contractorRadio.checked && !userRadio.checked) {
                userRadio.checked = true;
            }

            toggleContractorFields();
        });
    </script>

</x-layout.app-layout>
