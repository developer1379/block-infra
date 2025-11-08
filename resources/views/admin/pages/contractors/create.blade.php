<x-admin.app>
    <style>
        .card {
            border-radius: 10px;
        }

        .btn-save {
            background: #b3d33c;
            color: #000;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: #a0c32f;
            color: #000;
        }

        .form-check-input:checked {
            background-color: #b3d33c;
            border-color: #b3d33c;
        }

        .form-label {
            font-weight: 500;
            color: #212529;
        }
    </style>

    <div class="page-wrapper">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Add New Contractor</h4>
                <small class="text-muted">Create contractor profile & assign category</small>
            </div>
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.contractors.store') }}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter contractor name"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company Name --}}
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="form-control @error('company_name') is-invalid @enderror"
                            placeholder="Enter company name">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="form-control @error('city') is-invalid @enderror" placeholder="Enter city">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contractor Category --}}
                    @php
                        $categories = \App\Models\Category::where('is_active', 1)->orderBy('name')->get();
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Contractor Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="active"
                                value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                value="0" {{ old('is_active') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="inactive">Inactive</label>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-save px-4">
                            <i class="fa fa-save mr-1"></i> Save Contractor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app>
