<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Add Unit</h5>
        <a href="{{ route('admin.units.index') }}" class="btn btn-sm btn-outline-dark mt-2 mt-sm-0">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- ADD FORM --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-ruler-combined me-2" style="color:#b3d33c;"></i>New Unit
            </h6>
        </div>

        <div class="card-body p-3">
            <form action="{{ route('admin.units.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Unit Name --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm border-secondary"
                               placeholder="e.g., Square Feet" required>
                    </div>

                    {{-- Symbol --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Symbol <span class="text-danger">*</span></label>
                        <input type="text" name="symbol" class="form-control form-control-sm border-secondary"
                               placeholder="e.g., sqft" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="small fw-semibold">Description (optional)</label>
                        <textarea name="description" rows="2"
                                  class="form-control form-control-sm border-secondary"
                                  placeholder="Short note about the unit..."></textarea>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-12 d-flex align-items-center mt-2">
                        <input type="checkbox" id="isActive" name="is_active" value="1"
                               checked class="form-check-input me-2">
                        <label class="small fw-semibold mb-0" for="isActive">Active</label>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm px-4 fw-bold"
                            style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    @endpush

</x-admin.app>
