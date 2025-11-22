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

        .form-label {
            font-weight: 600;
            color: #212529;
        }

        .category-select {
            min-height: 160px;
            padding: 10px;
            border-radius: 8px;
        }

        .category-select option {
            padding: 6px;
            font-size: 14px;
        }

        .category-select option:hover {
            background: #b3d33c30;
        }
    </style>

    <div class="page-wrapper">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Edit Contractor</h4>
                <small class="text-muted">Update contractor information</small>
            </div>
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- EDIT FORM --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('admin.contractors.update', $contractor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $contractor->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter contractor name"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- COMPANY --}}
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name"
                            value="{{ old('company_name', $contractor->company_name) }}" class="form-control"
                            placeholder="Enter company name">
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $contractor->email) }}"
                            class="form-control" placeholder="Enter email">
                    </div>

                    {{-- PHONE --}}
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $contractor->phone) }}"
                            class="form-control" placeholder="Enter phone number">
                    </div>

                    {{-- CITY --}}
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city', $contractor->city) }}"
                            class="form-control" placeholder="Enter city">
                    </div>

                    {{-- MULTIPLE CATEGORIES --}}
                    @php
                        $parentCategories = \App\Models\Category::query()
                            ->with([
                                'subcategories' => function ($q) {
                                    $q->where('is_active', 1);
                                },
                            ])
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    <div class="mb-3">
                        <label class="form-label">Select Categories (Multiple)</label>

                        <select name="categories[]" multiple class="form-control category-select">
                            @foreach ($parentCategories as $parent)
                                @php $children = $parent->subcategories; @endphp

                                @if ($children->count())
                                    <optgroup label="{{ $parent->name }}">
                                        @foreach ($children as $child)
                                            <option value="{{ $child->id }}" class="text-black"
                                                {{ in_array($child->id, old('categories', $contractor->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $parent->id }}" class="text-black"
                                        {{ in_array($parent->id, old('categories', $contractor->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <small class="text-muted">Hold CTRL to select multiple categories</small>
                    </div>

                    {{-- STATUS --}}
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

                    {{-- DOCUMENT LIST --}}
                    @if ($contractor->documents && $contractor->documents->count() > 0)
                        <div class="mb-4">
                            <label class="form-label">Documents</label>
                            <div class="border rounded p-3 bg-light">
                                @foreach ($contractor->documents as $doc)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>
                                            <i class="fa fa-file text-secondary mr-2"></i>
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                {{ ucfirst($doc->document_type) }}
                                            </a>
                                        </span>

                                        <span
                                            class="badge {{ $doc->is_verified ? 'badge-success' : 'badge-warning' }}">
                                            {{ $doc->is_verified ? 'Verified' : 'Pending' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- SUBMIT --}}
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
