<x-admin.app>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Add Project</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- CREATE PROJECT FORM --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-plus-circle me-2" style="color:#b3d33c;"></i>Create New Project
            </h6>
        </div>

        <div class="card-body p-3">

            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Project Title --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-sm border-secondary"
                            value="{{ old('title') }}" required>
                    </div>

                    {{-- Budget Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Min (₹)</label>
                        <input type="number" name="budget_min" step="0.01"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Budget Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Max (₹)</label>
                        <input type="number" name="budget_max" step="0.01"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Location</label>
                        <input type="text" name="location" class="form-control form-control-sm border-secondary"
                            value="{{ old('location') }}">
                    </div>



                    {{--  MULTIPLE CATEGORIES --}}
                    @php
                        $parentCategories = \App\Models\Category::query()
                            ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    <div class="col-md-12">
                        <label class="small fw-semibold">Select Categories (Multiple)</label>

                        <select name="categories[]" multiple
                            class="form-control form-control-sm border-secondary category-select"
                            style="min-height: 160px;">

                            @foreach ($parentCategories as $parent)
                                @php $children = $parent->subcategories; @endphp

                                @if ($children->count())
                                    <optgroup label="{{ $parent->name }}">
                                        @foreach ($children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ collect(old('categories'))->contains($child->id) ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $parent->id }}"
                                        {{ collect(old('categories'))->contains($parent->id) ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endif
                            @endforeach

                        </select>

                        <small class="text-muted">Hold CTRL to select multiple categories.</small>

                        @error('categories')
                            <span class="text-danger small d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="small fw-semibold">Description <span class="text-danger">*</span></label>
                        <input type="hidden" name="description" id="descriptionInput"
                            value="{{ old('description') }}">
                        <div id="quillEditor" style="height:250px; background:#fff; border:1px solid #ced4da;"></div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button class="btn btn-sm fw-bold px-4" style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save me-1"></i> Save Project
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- Optional Styling --}}
    <style>
        .category-select option {
            padding: 6px;
        }

        .category-select optgroup {
            font-weight: 700;
            color: #333;
        }

        .category-select option:hover {
            background-color: #b3d33c30 !important;
        }
    </style>

</x-admin.app>
