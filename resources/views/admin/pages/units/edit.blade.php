<x-admin.app>
    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h4 class="text-uppercase font-weight-bold mb-1" style="color:#b3d33c;">Edit Unit</h4>
            <small class="text-muted">Update measurement unit details</small>
        </div>
        <a href="{{ route('admin.units.index') }}" class="btn btn-outline-dark btn-sm mt-2 mt-sm-0">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- EDIT FORM --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 font-weight-bold text-dark">
                <i class="fa fa-edit mr-2" style="color:#b3d33c;"></i>Edit Unit
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    {{-- Unit Name --}}
                    <div class="form-group col-md-6">
                        <label class="font-weight-semibold text-dark">Unit Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                            class="form-control border-secondary" placeholder="e.g., Square Feet" required>
                    </div>

                    {{-- Symbol --}}
                    <div class="form-group col-md-6">
                        <label class="font-weight-semibold text-dark">Symbol <span class="text-danger">*</span></label>
                        <input type="text" name="symbol" value="{{ old('symbol', $unit->symbol) }}"
                            class="form-control border-secondary" placeholder="e.g., sqft" required>
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold text-dark">Description</label>
                        <textarea name="description" rows="2" class="form-control border-secondary"
                            placeholder="Short note about the unit">{{ old('description', $unit->description) }}</textarea>
                    </div>

                    {{-- Active Checkbox --}}
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="isActive" name="is_active"
                                value="1" {{ $unit->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-semibold text-dark" for="isActive">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="text-right">
                    <button type="submit" class="btn px-4 font-weight-bold"
                        style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save mr-1"></i> Update Unit
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    @endpush
</x-admin.app>
