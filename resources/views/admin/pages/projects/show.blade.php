<x-admin.app>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold" style="color:#b3d33c;">Project Details</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- DETAILS CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-folder-open me-2" style="color:#b3d33c;"></i>Project Information
            </h6>
        </div>

        <div class="card-body p-3">

            <h5 class="fw-bold">{{ $project->title }}</h5>
            <p class="text-muted">{{ $project->description }}</p>

            <div class="row mt-3">

                <div class="col-md-4 mb-2">
                    <strong>Budget:</strong>
                    ₹{{ $project->budget_min }} - ₹{{ $project->budget_max }}
                </div>

                <div class="col-md-4 mb-2">
                    <strong>Location:</strong> {{ $project->location }}
                </div>

                <div class="col-md-4 mb-2">
                    <strong>Status:</strong>
                    <span class="badge bg-info">{{ ucfirst($project->status) }}</span>
                </div>

            </div>

            <hr>

            <a href="{{ route('admin.projects.bids', $project->id) }}" class="btn btn-sm btn-dark">
                <i class="fa fa-gavel me-1"></i> View Bids
            </a>

        </div>

    </div>

</x-admin.app>
