<x-admin.app>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold" style="color:#b3d33c;">Project Details</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- DETAILS CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-folder-open mr-2" style="color:#b3d33c;"></i>Project Information
            </h6>

            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-success fw-bold px-3">
                <i class="fa fa-edit mr-1"></i>Edit
            </a>
        </div>

        <div class="card-body p-4">

            {{-- TITLE --}}
            <h3 class="fw-bold mb-2">{{ $project->title }}</h3>

            {{-- ⭐ QUILL HTML RENDER --}}
            <div class="project-description mb-4">
                {!! $project->description !!}
            </div>

            {{-- PROJECT DETAILS --}}
            <div class="row mb-4">

                {{-- BUDGET --}}
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light border rounded shadow-sm-sm">
                        <p class="text-secondary small mb-1">Budget</p>
                        <h6 class="fw-bold mb-0">
                            ₹{{ number_format($project->budget_min, 2) }} —
                            ₹{{ number_format($project->budget_max, 2) }}
                        </h6>
                    </div>
                </div>

                {{-- LOCATION --}}
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light border rounded shadow-sm-sm">
                        <p class="text-secondary small mb-1">Location</p>
                        <h6 class="fw-bold mb-0">{{ $project->location ?? '—' }}</h6>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light border rounded shadow-sm-sm">
                        <p class="text-secondary small mb-1">Status</p>
                        <span class="badge badge-info px-3 py-1 text-uppercase">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- CATEGORIES --}}
            <div class="mb-4">
                <p class="fw-semibold mb-1">Categories</p>

                @if ($project->categories->count())
                    @foreach ($project->categories as $cat)
                        <span class="badge px-3 py-2 mr-1 mb-1"
                            style="background-color:#b3d33c;color:#000;font-weight:600;border-radius:6px;">
                            <i class="fa fa-tag mr-1"></i>{{ $cat->name }}
                        </span>
                    @endforeach
                @else
                    <p class="text-muted">No categories added.</p>
                @endif
            </div>

            <hr class="my-4">

            {{-- ACTION BUTTONS --}}
            <div class="mt-3">
                <a href="{{ route('admin.projects.bids', $project->id) }}" class="btn btn-dark btn-sm fw-bold">
                    <i class="fa fa-gavel mr-1"></i> View Bids
                </a>
            </div>

        </div>
    </div>

    {{-- QUILL READABILITY STYLES --}}
    <style>
        .project-description img {
            max-width: 100%;
            border-radius: 6px;
            margin: 10px 0;
        }

        .project-description iframe,
        .project-description video {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 6px;
        }

        .project-description p {
            font-size: 15px;
            line-height: 1.6;
        }
    </style>

</x-admin.app>
