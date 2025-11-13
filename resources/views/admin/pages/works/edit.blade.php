<x-admin.app>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Edit Work</h5>
        <a href="{{ route('admin.works.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0"><i class="fa fa-edit me-2" style="color:#b3d33c;"></i>Work Information</h6>
        </div>

        <div class="card-body p-3">
            <form action="{{ route('admin.works.update', $work->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Work Name --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Work Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $work->name) }}"
                            class="form-control form-control-sm border-secondary" placeholder="Enter work name"
                            required>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control form-control-sm border-secondary" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $work->category_id == $category->id ? 'selected' : '' }}>
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
                                <option value="{{ $unit->id }}" {{ $work->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }} {{ $unit->symbol ? "($unit->symbol)" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Labor Cost Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor Min (₹)</label>
                        <input type="number" name="labor_min" step="0.01"
                            value="{{ old('labor_min', $work->labor_min) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Labor Cost Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor Max (₹)</label>
                        <input type="number" name="labor_max" step="0.01"
                            value="{{ old('labor_max', $work->labor_max) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Material Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor + Material Min (₹)</label>
                        <input type="number" step="0.01" name="labor_material_min"
                            value="{{ old('labor_material_min', $work->labor_material_min) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Material Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Labor + Material Max (₹)</label>
                        <input type="number" step="0.01" name="labor_material_max"
                            value="{{ old('labor_material_max', $work->labor_material_max) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-12 d-flex align-items-center mt-2 ml-4">
                        <input type="checkbox" id="isActive" name="is_active" value="1"
                            {{ $work->is_active ? 'checked' : '' }} class="form-check-input me-2">
                        <label for="isActive" class="small fw-semibold mb-0">Active</label>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm px-4 fw-bold" style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-check me-1"></i> Update
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    @endpush

</x-admin.app>
