<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Add Work</h5>
        <a href="{{ route('admin.works.index') }}" class="btn btn-sm btn-outline-dark mt-2 mt-sm-0">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- ADD FORM --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-plus-circle me-2" style="color:#b3d33c;"></i>Create New Work
            </h6>
        </div>

        <div class="card-body p-3">
            <form action="{{ route('admin.works.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Work Name --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Work Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm border-secondary"
                            placeholder="Enter work name" required>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control form-control-sm border-secondary" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Measurement Unit</label>
                        <select name="unit_id" class="form-control form-control-sm border-secondary">
                            <option value="">Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->name }} ({{ $unit->symbol }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Labor Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor Min (₹)</label>
                        <input type="number" step="0.01" name="labor_min"
                            class="form-control form-control-sm border-secondary" placeholder="0.00">
                    </div>

                    {{-- Labor Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor Max (₹)</label>
                        <input type="number" step="0.01" name="labor_max"
                            class="form-control form-control-sm border-secondary" placeholder="0.00">
                    </div>

                    {{-- Labor + Material Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Lab + Material Min (₹)</label>
                        <input type="number" step="0.01" name="labor_material_min"
                            class="form-control form-control-sm border-secondary" placeholder="0.00">
                    </div>

                    {{-- Labor + Material Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Lab + Material Max (₹)</label>
                        <input type="number" step="0.01" name="labor_material_max"
                            class="form-control form-control-sm border-secondary" placeholder="0.00">
                    </div>

                    {{-- Unit Label --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Unit Label (optional)</label>
                        <input type="text" name="unit_label" class="form-control form-control-sm border-secondary"
                            placeholder="e.g., per sqft, project-wise">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="small fw-semibold">Description (optional)</label>
                        <textarea name="description" rows="2" class="form-control form-control-sm border-secondary"
                            placeholder="Short note about the work..."></textarea>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-12 d-flex align-items-center mt-2 ml-4">
                        <input type="checkbox" id="isActive" name="is_active" value="1" checked
                            class="form-check-input me-2">
                        <label for="isActive" class="small fw-semibold mb-0">Active</label>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm px-4 fw-bold" style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save me-1"></i> Save Work
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    @endpush

</x-admin.app>
