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

                        {{-- Contractor Category (only when contractor selected) --}}
                        <div class="mb-3" id="contractorCategoryField">
                            <label class="form-label fw-semibold text-dark">Contractor Category</label>
                            <select name="contractor_category" class="form-select border-dark-subtle">
                                <option value="" disabled {{ old('contractor_category') ? '' : 'selected' }}>
                                    Select Category</option>

                                @foreach ($parentCategories as $parent)
                                    @php $children = $parent->subcategories; @endphp

                                    @if ($children->count())
                                        <optgroup label="{{ $parent->name }}">
                                            @foreach ($children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ old('contractor_category') == $child->id ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        {{-- If no subcategories, allow selecting the parent itself --}}
                                        <option value="{{ $parent->id }}"
                                            {{ old('contractor_category') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
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
