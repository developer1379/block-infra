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
        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Edit Contractor</h4>
                <small class="text-muted">Update contractor details or change status</small>
            </div>
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- EDIT FORM --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.contractors.update', $contractor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $contractor->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter contractor name"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company --}}
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name"
                            value="{{ old('company_name', $contractor->company_name) }}" class="form-control"
                            placeholder="Enter company name">
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $contractor->email) }}"
                            class="form-control" placeholder="Enter email">
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $contractor->phone) }}"
                            class="form-control" placeholder="Enter phone number">
                    </div>

                    {{-- City --}}
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city', $contractor->city) }}"
                            class="form-control" placeholder="Enter city">
                    </div>

                    {{-- Contractor Category --}}
                    @php
                        $categories = \App\Models\Category::query()->where('is_active', 1)->orderBy('name')->get();
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Contractor Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $contractor->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="form-group mb-4">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="active"
                                value="1" {{ $contractor->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                value="0" {{ !$contractor->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="inactive">Inactive</label>
                        </div>
                    </div>

                    {{-- Documents Section (optional) --}}
                    @if (isset($contractor->documents) && $contractor->documents->count() > 0)
                        <div class="mb-4">
                            <label class="form-label">Documents</label>
                            <div class="border rounded p-3 bg-light">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($contractor->documents as $doc)
                                        <li class="mb-2 d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="fa fa-file text-secondary mr-2"></i>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                    target="_blank">{{ $doc->document_type }}</a>
                                            </span>
                                            <span
                                                class="badge {{ $doc->is_verified ? 'badge-success' : 'badge-warning' }}">
                                                {{ $doc->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Save Button --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-save px-4">
                            <i class="fa fa-save mr-1"></i> Update Contractor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app>
