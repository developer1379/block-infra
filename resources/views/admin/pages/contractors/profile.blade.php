<x-admin.app>

    <style>
        .profile-card {
            border-radius: 10px;
        }

        .profile-image {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #b3d33c;
        }

        .form-label-custom {
            font-size: 13px;
            font-weight: 600;
            color: #444;
        }
    </style>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold" style="color:#b3d33c;">My Profile</h5>

        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- PROFILE CARD --}}
    <div class="card shadow profile-card border-0">

        <div class="card-body p-4">

            {{-- PROFILE IMAGE --}}
            <div class="text-center mb-4">
                @php
                    $imagePath = auth()->user()->contractor->image ?? null;
                @endphp

                <img src="{{ $imagePath ? asset('storage/' . $imagePath) : asset('default-avatar.png') }}"
                    class="profile-image mb-2">


                <h5 class="fw-bold mb-0">{{ auth()->user()->name }}</h5>
                <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
            </div>

            <hr>

            {{-- PROFILE FORM --}}
            <form action="{{ route('contractor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- NAME --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                            class="form-control form-control-sm border-secondary" required>
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- PHONE --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Phone</label>
                        <input type="text" name="phone" value="{{ auth()->user()->contractor->phone }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- CITY --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">City</label>
                        <input type="text" name="city" value="{{ auth()->user()->contractor->city }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- CATEGORIES --}}
                    @php
                        $parentCategories = \App\Models\Category::with('subcategories')
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();

                        // Correct selected categories from contractor model
                        $selectedCategories = auth()->user()->contractor
                            ? auth()->user()->contractor->categories->pluck('id')->toArray()
                            : [];
                    @endphp

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Categories (Multiple)</label>

                        <select name="categories[]" multiple class="form-control category-select"
                            style="min-height: 150px;">
                            @foreach ($parentCategories as $parent)
                                @if ($parent->subcategories->count())
                                    <optgroup label="{{ $parent->name }}">
                                        @foreach ($parent->subcategories as $child)
                                            <option value="{{ $child->id }}"
                                                {{ in_array($child->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $parent->id }}"
                                        {{ in_array($parent->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <small class="text-muted">Hold CTRL to select multiple categories</small>
                    </div>


                    {{-- PROFILE PHOTO --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label-custom">Profile Photo</label>
                        <input type="file" name="image" accept="image/*" style="height: 35px;"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- PASSWORD CHANGE --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">New Password</label>
                        <input type="password" name="password" class="form-control form-control-sm border-secondary"
                            placeholder="Leave empty if not changing">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-control form-control-sm border-secondary" placeholder="Confirm password">
                    </div>

                </div>

                <div class="text-right mt-3">
                    <button class="btn px-4 fw-bold" style="background:#b3d33c;color:#000;">
                        <i class="fa fa-save mr-1"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            @if (session('success'))
                Swal.fire({
                    title: "Profile Updated!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#28a745"
                });
            @endif
        </script>
    @endpush

</x-admin.app>
