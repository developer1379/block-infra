<x-admin.app>
    <div class="">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Edit Work</h4>
            <a href="{{ route('admin.works.index') }}" class="btn btn-outline-dark btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.works.update', $work->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Work Name</label>
                            <input type="text" name="name" value="{{ old('name', $work->name) }}"
                                class="form-control border-dark-subtle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select border-dark-subtle" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($work->category_id == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit</label>
                            <select name="unit_id" class="form-select border-dark-subtle">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @selected($work->unit_id == $unit->id)>
                                        {{ $unit->name }} ({{ $unit->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Labor Cost (₹)</label>
                            <input type="number" step="0.01" name="labor_cost"
                                value="{{ old('labor_cost', $work->labor_cost) }}"
                                class="form-control border-dark-subtle">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Material Cost (₹)</label>
                            <input type="number" step="0.01" name="material_cost"
                                value="{{ old('material_cost', $work->material_cost) }}"
                                class="form-control border-dark-subtle">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    {{ $work->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Active</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn px-4 fw-bold" style="background-color:#b3d33c;color:#000;">Update
                                Work</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    @endpush
</x-admin.app>
