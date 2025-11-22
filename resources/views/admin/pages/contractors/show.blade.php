<x-admin.app>

    <style>
        /* Layout Improvements */
        .card {
            border-radius: 12px;
            border: none;
        }

        .info-label {
            font-weight: 600;
            color: #343a40;
        }

        .info-value {
            font-size: 15px;
            color: #555;
            margin-bottom: 12px;
        }

        .badge-category {
            background: #17a2b8;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #fff;
        }

        .badge-verified {
            background-color: #28a745;
            padding: 5px 10px;
            font-size: 12px;
        }

        .badge-pending {
            background-color: #ffc107;
            padding: 5px 10px;
            font-size: 12px;
            color: #000;
        }

        .doc-title {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .document-card {
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fa;
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
        }

        .document-card:hover {
            background: #eef1f4;
            border-color: #cfd4d8;
        }

        .btn-verify {
            background-color: #b3d33c;
            color: #000;
            padding: 5px 12px;
            font-size: 13px;
            border-radius: 4px;
        }

        .btn-verify:hover {
            background-color: #a0c32f;
            color: #000;
        }
    </style>


    <div class="page-wrapper">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Contractor Details</h4>
                <small class="text-muted">Profile overview and submitted documents</small>
            </div>

            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>


        {{-- MAIN CARD --}}
        <div class="card shadow-sm">
            <div class="card-body p-4">

                {{-- Basic Info --}}
                <h5 class="fw-bold text-dark mb-3">Basic Information</h5>
                <div class="row">

                    <div class="col-md-6">
                        <p class="info-label">Name</p>
                        <p class="info-value">{{ $contractor->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Company Name</p>
                        <p class="info-value">{{ $contractor->company_name ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Email</p>
                        <p class="info-value">{{ $contractor->email }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Phone</p>
                        <p class="info-value">{{ $contractor->phone ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">City</p>
                        <p class="info-value">{{ $contractor->city ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Categories</p>

                        <p class="info-value">
                            @forelse($contractor->categories as $cat)
                                <span class="badge badge-category mr-1">{{ $cat->name }}</span>
                            @empty
                                <span class="text-muted">No categories assigned</span>
                            @endforelse
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Status</p>

                        @if ($contractor->is_active)
                            <span class="badge badge-success px-3 py-1">Active</span>
                        @else
                            <span class="badge badge-secondary px-3 py-1">Inactive</span>
                        @endif
                    </div>

                </div>

                <hr>

                {{-- DOCUMENTS --}}
                <h5 class="fw-bold text-dark mb-3">Uploaded Documents</h5>

                @if ($contractor->documents->count() > 0)
                    <div class="row">
                        @foreach ($contractor->documents as $doc)
                            <div class="col-md-6 mb-3">
                                <div class="document-card">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="doc-title">
                                                <i class="fa fa-file mr-2 text-secondary"></i>
                                                {{ ucfirst($doc->document_type) }}
                                            </div>
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                View Document
                                            </a>
                                        </div>

                                        <div class="text-right">
                                            @if ($doc->is_verified)
                                                <span class="badge-verified">Verified</span>
                                            @else
                                                <span class="badge-pending">Pending</span>

                                                <form
                                                    action="{{ route('admin.contractor-documents.verify', $doc->id) }}"
                                                    method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-verify btn-sm">
                                                        <i class="fa fa-check mr-1"></i> Verify
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No documents uploaded yet.</p>
                @endif

            </div>
        </div>
    </div>

</x-admin.app>
