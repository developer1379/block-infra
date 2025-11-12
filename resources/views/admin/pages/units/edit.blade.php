<x-admin.app>
    <div class="">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Edit Unit</h4>
            <a href="{{ route('admin.units.index') }}" class="btn btn-outline-dark btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit Name</label>
                            <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                                   class="form-control border-dark-subtle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Symbol</label>
                            <input type="text" name="symbol" value="{{ old('symbol', $unit->symbol) }}"
                                   class="form-control border-dark-subtle" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control border-dark-subtle" rows="2">{{ old('description', $unit->description) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                       {{ $unit->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Active</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn px-4 fw-bold" style="background-color:#b3d33c;color:#000;">Update Unit</button>
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
