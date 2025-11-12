<x-admin.app>
    <div class="">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Add Unit</h4>
            <a href="{{ route('admin.units.index') }}" class="btn btn-outline-dark btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.units.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit Name</label>
                            <input type="text" name="name" class="form-control border-dark-subtle" placeholder="e.g., Square Feet" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Symbol</label>
                            <input type="text" name="symbol" class="form-control border-dark-subtle" placeholder="e.g., sqft" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description (optional)</label>
                            <textarea name="description" class="form-control border-dark-subtle" rows="2" placeholder="Short note about the unit"></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label fw-semibold">Active</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn px-4 fw-bold" style="background-color:#b3d33c;color:#000;">Save Unit</button>
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
